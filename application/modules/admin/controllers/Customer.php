<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->load->model('global_model');
        $this->load->model('sales_model', 'sales');
        $this->load->model('crud_model', 'crud');
        $this->load->library('grocery_CRUD');        
        $this->load->library('email_client');
        $this->mTitle = TITLE;
    }


    //------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------
    //************************* Customer Section *****************************************************************
    //------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------

    function customerList()
    {
        $this->mTitle .= lang('customer');
        $this->render('sales/customer/customer_list');
    }

    public function customerTable()
    {

        $this->global_model->table = 'customer';
        $this->global_model->column_order = array('name','company_name','phone_1',null);
        $this->global_model->column_search = array('name','company_name','phone_1','email');
        $this->global_model->order = array('id' => 'desc');

        $list = $this->global_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = '<a href="'. site_url('admin/customer/customerDetails/'.$item->id) .'">'.$item->name.'</a><br/>'.'<span style="color: grey">'.$item->company_name.'</span>';
            $row[] = $item->phone_1;
            $row[] = $item->email;
            //add html for action
            $row[] = '
            <div class="btn-group dropdown">
                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                       '. lang('actions').'                               <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="sales/type/invoice?nameID='.$item->id.'"><i class="fa fa-shopping-basket text-success"></i>'. lang('create_invoice').'</a>
                                                        </li>
                                                        <li>
                                                            <a href="'. site_url('admin/customer/customerDetails/'.$item->id) .'" ><i class="fa fa-pencil-square-o"></i>'. lang('edit').'</a>
                                                        </li>
                                                        <li>
                                                            <a onclick="return confirm(\'Are you sure you want to delete ? \');" href="customer/deleteCustomer/'. $item->id .'">
                                                                <i class="fa fa-trash-o"></i><span class="text-danger">'. lang('delete').'</span></a>
                                                        </li>
                                                    </ul>
                                                </div>
            ';
            $data[] = $row;
        }
        $this->global_model->render_table($data);
    }

    function deleteCustomer($id = null)
    {
        $order = $this->db->get_where('sales_order', array( 'customer_id' => $id ))->row();

        if($order){
            $this->message->custom_error_msg('admin/customer/customerList', lang('sorry_you_can_not_delete_used_by_other'));
        }else{
            //delete
            $this->db->delete('customer', array('id' => $id));
            $this->message->delete_success('admin/customer/customerList');
        }


    }

    function newCustomer()
    {
        $this->mViewData['form'] = $this->form_builder->create_form('admin/customer/saveCustomer',true, array('id'=>'CustomerForm'));
        $this->mViewData['countries'] = $this->db->get('countries')->result();
        $countries = $this->mViewData['countries'];
		$countries_opts = array('' => 'Please select country');
		if(!empty($countries))
		{
			foreach($countries as $country)
			{
				$countries_opts[$country->phonecode.'_'.$country->name]  = $country->name." +".$country->phonecode;
			}
		}
		$this->mViewData['country_opts'] = $countries_opts;
        $this->mTitle .= lang('add_new_customer');
        $this->render('sales/customer/add_customer');
    }

    function save_customer_personal_info()
    {

        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));

        if(empty($id)){
            $this->message->norecord_found('admin/customer/customerList');
        }

        $tab = $this->input->post('tab_view');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean'); 
        $this->form_validation->set_rules('phone_1', 'Phone 1', 'trim|xss_clean|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|xss_clean|required');
        $this->form_validation->set_rules('state', 'City', 'trim|xss_clean|required');
        $this->form_validation->set_rules('city', 'City', 'trim|xss_clean|required');

        if ($this->form_validation->run()== TRUE) {
            $city = $this->input->post('city');

            if($city =='Others'){
                $citydata['name']= $this->input->post('other_city');
                $citydata['state_id']= $this->input->post('state');
                $this->db->insert('cities', $citydata);
                $cityid = $this->db->insert_id();
            }

            $data['name'] = $this->input->post('name');
            $data['phone_1'] = $this->input->post('phone_1');
            $data['website'] = $this->input->post('website');
            $data['country'] = $this->input->post('country');
            $data['zipcode'] = $this->input->post('zipcode');
            $data['email'] = $this->input->post('email');
            $data['state'] = $this->input->post('state');
            $data['city'] = ($city =='Others') ? $cityid : $this->input->post('city');
            $data['address'] = $this->input->post('address');

            $this->db->where('id', $id);
            $this->db->update('customer', $data);
            

            $this->message->save_success('admin/customer/customerDetails?tab='.$tab.'/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)));
        }else
        {
            $error = validation_errors();;

            $this->message->custom_error_msg('admin/customer/customerDetails?tab='.$tab.'/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) ,$error);
        }

    }

    function saveCustomer(){
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone_1', 'Phone 1', 'trim|xss_clean|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|xss_clean|required');
        $this->form_validation->set_rules('state', 'City', 'trim|xss_clean|required');
        $this->form_validation->set_rules('city', 'City', 'trim|xss_clean|required');
        
        if ($this->form_validation->run() == TRUE) {
            $city = $this->input->post('city');

            if($city =='Others'){
                $citydata['name']= $this->input->post('other_city');
                $citydata['state_id']= $this->input->post('state');
                $this->db->insert('cities', $citydata);
                $cityid = $this->db->insert_id();
            }

            $data['name'] = $this->input->post('name');
            $data['phone_1'] = $this->input->post('phone_1');
            $data['country'] = $this->input->post('country');
            $data['zipcode'] = $this->input->post('zipcode');
            $data['email'] = $this->input->post('email');
            $data['state'] = $this->input->post('state');
            $data['city'] = ($city =='Others') ? $cityid : $this->input->post('city');
            $data['address'] = $this->input->post('address');

            $id = $this->input->post('id');

            if($id){
                $this->db->where('id', $id);
                $this->db->update('customer', $data);
            }else{
                $this->db->insert('customer', $data);
                $id = $this->db->insert_id();

                $data = array();
                $data['customer_code'] = 1000 + $id;

                $this->db->where('id', $id);
                $this->db->update('customer', $data);

            }

            $this->message->save_success('admin/customer/customerList');
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/customer/newCustomer', $error);
        }
    }


    function customerDetails($id =null)
    {
        if(empty($id)) {
            $url = $this->input->get('tab');
            $pieces = explode("/", $url);
            $tab = $pieces[0];
            $id = $pieces[1];
        }

        //select customer from database        
        $data['customer'] = $this->db->get_where('customer', array( 'id' => $id ))->row();
        //country
        $data['countries'] = $this->db->get('countries')->result();

        $data['customer'] == TRUE || $this->message->norecord_found('admin/customer/customerList');

        if(!$this->input->get('tab') || $tab == 'personal' )
        {
            $view   = 'personal';
            $tab    = 'personal';
            $this->mTitle .= lang('personal_details');
        }
        elseif($tab == 'login')
        {
            $view   = $tab;
            $tab    = $tab;
            $data['login'] = $this->db->get_where('customer_users', array('customer_id' => $id))->row();
            $this->mTitle .= lang('customer_login');
        }

        $countryID=$this->global_model->select_field_where_db('countries',array('id ="'.$data['customer']->country.'"'),'id');        
        $stateID=$this->global_model->select_field_where_db('states',array('id ="'.$data['customer']->state.'"'),'id');
        $data['countries'] = $this->db->get('countries')->result();
        $data['states'] = $this->db->get_where('states', array( 'country_id' => $countryID ))->result();
        $data['cities'] = $this->db->get_where('cities', array( 'state_id' => $stateID ))->result();
        $countries = $data['countries'];
        $countries_opts = array('' => 'Please select country');
        if(!empty($countries))
        {
            foreach($countries as $country)
            {
                $countries_opts[$country->phonecode.'_'.$country->name]  = $country->name." +".$country->phonecode;
            }
        }
        $data['country_opts'] = $countries_opts;

        $data['form']  = $this->form_builder->create_form();
        $this->mViewData['tab']                 = $tab;
        $this->mViewData['tab_view']            = $this->load->view('admin/sales/customer/includes/'.$view,$data,true);
        $this->render('sales/customer/customer_details');
    }


    function editCustomer($id = null)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));

        $this->mViewData['customer'] = $this->db->get_where('customer', array( 'id' => $id ))->row();
        $countryID=$this->global_model->select_field_where_db('countries',array('id ="'.$this->mViewData['customer']->country.'"'),'id');        
        $stateID=$this->global_model->select_field_where_db('states',array('id ="'.$this->mViewData['customer']->state.'"'),'id');
        $this->mViewData['countries'] = $this->db->get('countries')->result();
        $this->mViewData['states'] = $this->db->get_where('states', array( 'country_id' => $countryID ))->result();
        $this->mViewData['cities'] = $this->db->get_where('cities', array( 'state_id' => $stateID ))->result();
        ///$this->mViewData['states'] = $this->db->get('states')->result();
        //$this->mViewData['cities'] = $this->db->get('cities')->result();
        $countries = $this->mViewData['countries'];
		$countries_opts = array('' => 'Please select country');
		if(!empty($countries))
		{
			foreach($countries as $country)
			{
				$countries_opts[$country->phonecode.'_'.$country->name]  = $country->name." +".$country->phonecode;
			}
		}
		$this->mViewData['country_opts'] = $countries_opts;
        $this->mViewData['form'] = $this->form_builder->create_form('admin/customer/saveCustomer',true, array('id'=>'from-product'));
        $this->mTitle .= lang('add_new_customer');
        $this->render('sales/customer/add_customer');
    }

    //=================================================================
    //*************************Customer Create Login*******************
    //=================================================================

    function create_user()
    {
        $id = $this->input->post('id');

        if(empty($id)){
            $this->message->norecord_found('admin/customer/customerList');
        }

        $this->form_validation->set_rules('password', lang('password'), 'required');
        $this->form_validation->set_rules('retype_password', lang('retype_password'), 'required|matches[password]');

        if ($this->form_validation->run()== TRUE) {

            $loginID =  $this->db->get_where('customer', array(
                'id' => $id
            ))->row();
            
            $customer_id    = $id;
            $email = $loginID->email;
            $password       = $this->input->post('password');
            $identity = empty($username) ? $email : $username;
            $additional_data = array(
                'customer_id'  => $customer_id
            );
            $groups         = array('0'=>2);

            // [IMPORTANT] override database tables to update Frontend Users instead of Admin Users
            $this->ion_auth_model->tables = array(
                'customer_users'    => 'customer_users',
                'groups'            => 'groups',
                'users_groups'      => 'users_groups',
                'login_attempts'    => 'login_attempts',
            );

            // proceed to create user
            $user_id = $this->ion_auth->customer_register($identity, $password,$email ,$additional_data, $groups);

            if ($user_id)
            {
                // success
                $messages = $this->ion_auth->messages();
                $this->system_message->set_success($messages);

                // directly activate user
                $this->ion_auth->activate($user_id);
            }
            else
            {
                // failed
                $errors = $this->ion_auth->errors();
                $this->message->custom_error_msg('admin/customer/customerDetails?tab=login/'.$id,$errors);
            }

            $this->message->save_success('admin/customer/customerDetails?tab=login/'.$id);
        }else
        {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/customer/customerDetails?tab=login/'.$id,$error);
        }
    }

    //=============================================================
    //  Import Customer
    //=============================================================
    function downloadCustomerSample()
    {
        $this->load->helper('download');
        $file = base_url().SAMPLE_FILE.'/'.'customer.csv';
        $data =  file_get_contents($file);
        force_download('customer.csv', $data);
    }

    function importCustomer(){
        if(isset($_POST["submit"]))
        {
            $tmp = explode(".", $_FILES['import']['name']); // For getting Extension of selected file
            $extension = end($tmp);

            $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
            if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
            {
                $this->load->library('Data_importer');
                $file = $_FILES["import"]["tmp_name"]; // getting temporary source of excel file
                $this->data_importer->customer_excel_import($file);
            }else{
                $this->message->custom_error_msg('admin/customer/importCustomer','Failed to Import Data');
            }
        }


        $this->mViewData['form'] = $this->form_builder->create_form();
        $this->mTitle .= lang('import_data');
        $this->render('import/import_customer');
    }
    
    //=================================================================
    //*************************Customer Domain Hosting*******************
    //=================================================================
    function add_new_domain($id)
    {   
        $data['id'] = $id;
        $data['modal_subview'] = $this->load->view('admin/sales/customer/_modals/new_domain',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function add_new_hosting($id)
    {   
        $data['id'] = $id;
        $data['modal_subview'] = $this->load->view('admin/sales/customer/_modals/new_hosting',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function edit_customer_domain($id)
    {
        $data['domain'] = $this->db->get_where('customer_domain', array(
                                        'id' => $id
                                    ))->row();
        $data['id'] = str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($data['domain']->customer_id));
        $data['modal_subview'] = $this->load->view('admin/sales/customer/_modals/new_domain',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }

    function edit_customer_hosting($id)
    {
        $data['hosting'] = $this->db->get_where('customer_hosting', array(
                                        'id' => $id
                                    ))->row();
        $data['id'] = str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($data['hosting']->customer_id));
        $data['modal_subview'] = $this->load->view('admin/sales/customer/_modals/new_hosting',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal_small', $data);
    }
    
    function sendEmail($email='',$customer){
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => get_option('smtp_host'),
            'smtp_port' => get_option('smtp_port'),
            'smtp_user' => get_option('smtp_username'),
            'smtp_pass' => get_option('smtp_password'),
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'wordwrap'  => TRUE,
        );
        $this->load->library('email', $config);

        $this->email->from(get_option('all_other_mails_from'), get_option('mail_sender'));
        $this->email->to($email);
        $data['customer'] = $customer;
        $msg = $this->load->view('admin/email/reminder/hosting',$data, TRUE);

        $this->email->subject('Hosting Expiry Reminder');
        $this->email->message($msg);
        var_dump($this->email->send());
        die;
    }

    function save_new_domain()
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
        if(empty($id)){
            $this->message->norecord_found('admin/customer/customerList');
        }
        $domain_id= $this->input->post('domain_id');

        $this->form_validation->set_rules('domain_name', 'Domain Name', 'required');
        $this->form_validation->set_rules('registered_date', 'Registered Date', 'required');
        $this->form_validation->set_rules('renewal_date', 'Renewal Date', 'required');

        if ($this->form_validation->run()== TRUE) {
            $data = array(
                'registered_date' => $this->input->post('registered_date'),
                'renewal_date' => $this->input->post('renewal_date'),
                'domain_name' => $this->input->post('domain_name'),
            );

            if(!empty($domain_id)){ //update
                $this->db->where('id', $domain_id);
                $this->db->update('customer_domain', $data);

                $domain = $this->db->get_where('customer_domain', array(
                    'id' => $domain_id
                ))->row();
            }else{//new insert
                $data['customer_id'] = $id;
                $this->db->insert('customer_domain', $data);
            }

            $this->message->save_success('admin/customer/customerDetails?tab=domain/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)));
        }else
        {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/customer/customerDetails?tab=domain/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) ,$error);
        }
    }

    function save_new_hosting()
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
        if(empty($id)){
            $this->message->norecord_found('admin/customer/customerList');
        }
        $hosting_id= $this->input->post('hosting_id');

        $this->form_validation->set_rules('hosting_company', 'Hosting Company Name', 'required');
        $this->form_validation->set_rules('hosting_space', 'Hosting Space', 'required');
        $this->form_validation->set_rules('hosting_company', 'Hosting Company Name', 'required');
        $this->form_validation->set_rules('renewal_date', 'Renewal Date', 'required');

        if ($this->form_validation->run()== TRUE) {
            $data = array(
                'renewal_date' => $this->input->post('renewal_date'),
                'hosting_company' => $this->input->post('hosting_company'),
                'hosting_space' => $this->input->post('hosting_space'),
                'hosting_type' => $this->input->post('hosting_type'),
            );

            if(!empty($hosting_id)){ //update
                $this->db->where('id', $hosting_id);
                $this->db->update('customer_hosting', $data);

                $domain = $this->db->get_where('customer_hosting', array(
                    'id' => $hosting_id
                ))->row();
            }else{//new insert
                $data['customer_id'] = $id;
                $this->db->insert('customer_hosting', $data);
            }

            $this->message->save_success('admin/customer/customerDetails?tab=domain/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)));
        }else
        {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/customer/customerDetails?tab=domain/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) ,$error);
        }
    }

    function domain_status($id = null)
    {
        $domain = $this->db->get_where('customer_domain', array(
            'id' => $id
        ))->row();

        $activeDomain = $this->db->get_where('customer_domain', array(
            'customer_id' => $domain->customer_id,
            'id' => $id,
        ))->row();

        if($activeDomain->status == 0)
        {
            $this->db->where('id', $activeDomain->id);
            $this->db->update('customer_domain', $data = array('status' => 1));
        }else{
            $this->db->where('id', $domain->id);
            $this->db->update('customer_domain', $data = array('status' => 0));
        }
        $this->message->save_success('admin/customer/customerDetails?tab=domain/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($domain->customer_id)));
    }
    
    function delete_domain($id = null){
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        if(empty($id)){
            $this->message->norecord_found('admin/customer/customerList');
        }
        $domain = $this->db->get_where('customer_domain', array(
            'id' => $id
        ))->row();

        //delete
        $this->db->delete('customer_domain', array('id' => $id));

        $this->message->delete_success('admin/customer/customerDetails?tab=domain/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($domain->customer_id)));
    }
}