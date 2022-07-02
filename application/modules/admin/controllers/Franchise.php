<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Franchise extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->mTitle = TITLE;
        $this->load->model('global_model');
        $this->load->model('attendance_model');

        $this->load->model('crud_model', 'crud');
        $this->load->library('grocery_CRUD');
    }



    function franchiseList()
    {
        $this->mViewData['modal'] = FALSE;
        $this->mTitle .= lang('franchise_list');
        $this->render('franchise/franchiseList');
    }

    public function franchiseTable(){
        $this->global_model->table = 'franchise';
        $list = $this->global_model->get_franchise_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->franchise_id;
            $row[] = $item->first_name.' '.$item->last_name;
            $row[] = $this->localization->dateFormat($item->joined_date);

            //add html for action
            $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" href="'. site_url('admin/franchise/franchiseDetails/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)) ) .'" ><i class="fa fa-search"></i></a>
				  <a class="btn btn-xs btn-danger" onClick="return confirm(\'Are you sure you want to delete?\')"  href="'. site_url('admin/franchise/Deletefranchise/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)) ) .'" >
				  <i class="glyphicon glyphicon-trash"></i></a></div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->global_model->count_activeEmployee(),
            "recordsFiltered" => $this->global_model->count_filtered_employee(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    function addFranchise()
    {
        $form = $this->form_builder->create_form('admin/franchise/addFranchise',true, array('id'=>'FranchiseForm'));
        if ($form->validate())
        {
           $prefix = FRANCHISE_ID_PREFIX;

           $data= array(
               'first_name'     => $this->input->post('first_name'),
               'last_name'      => $this->input->post('last_name'),
                'country'       => $this->input->post('country'),
           );

            $this->db->insert('franchise', $data);
            $id = $this->db->insert_id();

            $franchise_id = $prefix+$id;

            $contact_details = array(
                'address'         => $this->input->post('address'),
                'city'              => $this->input->post('city'),
                'state'             => $this->input->post('state'),
                'postal'            => $this->input->post('postal'),
                'country'           => $this->input->post('country'),
                'mobile'            => $this->input->post('mobile'),
                'work_telephone'    => $this->input->post('work_telephone'),
                'work_email'        => $this->input->post('work_email'),
                'other_email'       => $this->input->post('other_email'),
            );
            $data1['contact_details'] = json_encode($contact_details);

            $data1['franchise_id'] = $franchise_id;
            $data1['joined_date'] = $this->input->post('joined_date');
            

            $this->db->where('id', $id);
            $this->db->update('franchise', $data1);

            $this->message->save_success('admin/franchise/addFranchise');

        }


        $this->mTitle= lang('add_franchise');

        $this->mViewData['countries'] = $this->db->get('countries1')->result();
        $this->mViewData['form'] = $form;
        $this->render('franchise/create_franchise');
    }

    function franchiseDetails($id =null)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        
        if(empty($id)) {
            $url = $this->input->get('tab');
            $pieces = explode("/", $url);
            $tab = $pieces[0];
            $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $pieces[1]));
        }
        
        //select employee from database
        
        $data['franchise'] = $this->global_model->get_franchise($id);
        //country
        $data['countries'] = $this->db->get('countries1')->result();

        $data['franchise'] == TRUE || $this->message->norecord_found('admin/franchise/franchiseList');

        if(!$this->input->get('tab') || $tab == 'personal' )
        {
            $view   = 'personal';
            $tab    = 'personal';
            $this->mTitle .= lang('personal_details');
        }
        elseif($tab == 'contact')
        {
            $view   = $tab;
            $tab    = $tab;
            $this->mTitle .= lang('contact_details');
        }
        elseif($tab == 'login')
        {
            $view   = $tab;
            $tab    = $tab;
            $data['login'] = $this->db->get_where('users', array('franchise_id' => $id))->row();
            $this->mTitle .= lang('franchise_login');
        }
        elseif($tab == 'termination')
        {
            $view   = $tab;
            $tab    = $tab;
            $data['termination'] = $this->db->get_where('employee', array('id' => $id))->row();
            $this->mTitle .= lang('termination_note');
        }


        $data['form']  = $this->form_builder->create_form();
        $this->mViewData['tab']                 = $tab;
        $this->mViewData['tab_view']            = $this->load->view('admin/franchise/includes/'.$view,$data,true);
        $this->render('franchise/franchise_details');
    }



    //=================================================================
    //*********************Franchise Personal Details*******************
    //=================================================================
    
    function save_franchise_personal_info()
    {

        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));

        if(empty($id)){
            $this->message->norecord_found('admin/franchise/franchiseList');
        }

        $tab = $this->input->post('tab_view');

        $this->form_validation->set_rules('first_name', lang('first_name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('last_name', lang('last_name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('country', lang('country'), 'required');
        $this->form_validation->set_rules('address', lang('address_street'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('city', lang('city'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('state', lang('state_province'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('postal', lang('zip_postal_code'), 'trim|required|xss_clean');

        if ($this->form_validation->run()== TRUE) {
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'joined_date' => $this->input->post('joined_date'),
                'country' => $this->input->post('country'),
            );

            $contact_details = array(
                'address'         => $this->input->post('address'),
                'city'              => $this->input->post('city'),
                'state'             => $this->input->post('state'),
                'postal'            => $this->input->post('postal'),
                'country'           => $this->input->post('country'),
                'mobile'            => $this->input->post('mobile'),
                'work_telephone'    => $this->input->post('work_telephone'),
                'work_email'        => $this->input->post('work_email'),
                'other_email'       => $this->input->post('other_email'),
            );
            $data['contact_details'] = json_encode($contact_details);

            $this->db->where('id', $id);
            $this->db->update('franchise', $data);

            $this->message->save_success('admin/franchise/franchiseDetails?tab='.$tab.'/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)));
        }else
        {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/franchise/franchiseDetails?tab='.$tab.'/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) ,$error);
        }

    }

    //=================================================================
    //*************************Franchise Create Login*******************
    //=================================================================

    function create_user()
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));

        if(empty($id)){
            $this->message->norecord_found('admin/franchise/franchiseList');
        }

        $this->form_validation->set_rules('password', lang('password'), 'required');
        $this->form_validation->set_rules('retype_password', lang('retype_password'), 'required|matches[password]');

        if ($this->form_validation->run()== TRUE) {

            $loginID =  $this->db->get_where('franchise', array(
                            'id' => $id
                        ))->row();

            $franchise_id    = $id;
            $username       = $loginID->franchise_id;
            $email = '';
            $password       = $this->input->post('password');
            $identity = empty($username) ? $email : $username;
            $additional_data = array(
                'franchise_id'	=> $franchise_id
            );
            $groups         = array('0'=>1);

            // [IMPORTANT] override database tables to update Frontend Users instead of Admin Users
            $this->ion_auth_model->tables = array(
                'users'				=> 'users',
                'groups'			=> 'groups',
                'users_groups'		=> 'users_groups',
                'login_attempts'	=> 'login_attempts',
            );

            // proceed to create user
            $user_id = $this->ion_auth->register($identity, $password,$email ,$additional_data, $groups);
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
                $this->message->custom_error_msg('admin/franchise/franchiseDetails?tab=login/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)),$errors);
            }

            $this->message->save_success('admin/franchise/franchiseDetails?tab=login/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)));
        }else
        {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/franchise/franchiseDetails?tab=login/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)),$error);
        }
    }

    // Frontend User Reset Password
    public function reset_password()
    {
        // only top-level users can reset user passwords
        //$this->verify_auth(array('webmaster', 'admin'));

        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('id')));
        $user_id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('login_id')));

        if(empty($id)){
            $this->message->norecord_found('admin/franchise/franchiseList');
        }
        if(empty($user_id)){
            $this->message->norecord_found('admin/franchise/franchiseDetails?tab=login/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)));
        }

        $this->form_validation->set_rules('password', lang('password'), 'required');
        $this->form_validation->set_rules('retype_password', lang('retype_password'), 'required|matches[password]');

        if ($this->form_validation->run()== TRUE)
        {
            // pass validation
            $data = array('password' => $this->input->post('password'));

            // [IMPORTANT] override database tables to update Frontend Users instead of Admin Users
            $this->ion_auth_model->tables = array(
                'users'				=> 'users',
                'groups'			=> 'groups',
                'users_groups'		=> 'users_groups',
                'login_attempts'	=> 'login_attempts',
            );

            // proceed to change user password
            if ($this->ion_auth->update($user_id, $data))
            {
                $messages = $this->ion_auth->messages();
                $this->system_message->set_success($messages);
            }
            else
            {
                $errors = $this->ion_auth->errors();
                $this->message->custom_error_msg('admin/franchise/franchiseDetails?tab=login/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) ,$errors);
            }
            $this->message->custom_success_msg('admin/franchise/franchiseDetails?tab=login/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)), lang('password_update_successfully'));
        }else
        {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/franchise/franchiseDetails?tab=login/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)) ,$error);
        }
    }

    

    function change_status()
    {
        $id         = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('userId')));
        $status     = $this->input->post('status');

        $this->db->set('active', $status, FALSE)->where('id', $id)->update('users');
    }

    function reJoin($id=null){
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        if(empty($id))
        {
            $this->message->norecord_found('admin/franchise/franchiseList');
        }else{

            $this->db->set('termination', 1, FALSE)->where('id', $id)->update('employee');
            $this->db->set('active', 1, FALSE)->where('employee_id', $id)->update('users');

            $this->message->custom_success_msg('admin/franchise/franchiseDetails/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($id)), lang('re_join_employment_successfully') );

        }
    }

    function DeleteFranchise($id = null)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        if(empty($id))
            $this->message->norecord_found('admin/franchise/franchiseList');

        //delete
        $data['termination'] = 0;
        $data['soft_delete'] = 1;

        //update employee table
        $this->db->where('id', $id);
        $this->db->update('franchise', $data);

        //update employee login table
        $loginId =  $this->db->get_where('users', array(
            'franchise_id' => $id
        ))->row()->id;

        $this->db->delete('users', array('id' => $loginId));

        $this->message->custom_success_msg('admin/franchise/franchiseList', lang('employee_delete_success'));

    }

    //=============================================================
    //  Import Employee
    //=============================================================

    function downloadFranchiseSample()
    {
        $this->load->helper('download');
        $file = base_url().SAMPLE_FILE.'/'.'franchise.csv';
        $data =  file_get_contents($file);
        force_download('franchise.csv', $data);
    }

    function importFranchise(){
        if(isset($_POST["submit"]))
        {
            $tmp = explode(".", $_FILES['import']['name']); // For getting Extension of selected file
            $extension = end($tmp);
            $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
            if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
            {
                $this->load->library('Data_importer');
                $file = $_FILES["import"]["tmp_name"]; // getting temporary source of excel file
                $this->data_importer->franchise_excel_import($file);
            }else{
                $this->message->custom_error_msg('admin/franchise/importFranchise', lang('failed_to_import_data'));
            }
        }


        $this->mViewData['form'] = $this->form_builder->create_form();

        $this->mTitle .= lang('import_data');
        $this->render('import/import_franchise');
    }
}