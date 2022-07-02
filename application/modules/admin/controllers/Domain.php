<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Domain extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('global_model');
        $this->load->library('form_builder');
    }

    function index()
    {
        $this->mTitle= lang('domain_list');
        $data['search'] = (object)array(
            'filter'     => trim($this->input->get('filter')),
            'start_date' => (!empty($start_date)?trim($start_date):date('d-m-Y')),
            'end_date'   => (!empty($end_date)?trim($end_date):date('d-m-Y')),
        );
        $this->mViewData['search'] = $data['search'];
        $this->render('domain/domain_list');
    }
    
    public function report(){
        $start_date = $this->input->get('start_date');
        $end_date   = $this->input->get('end_date');
        $data['search'] = (object)array(
            'filter'     => trim($this->input->get('filter')),
            'start_date' => (!empty($start_date)?trim($start_date):date('Y-m-d')),
            'end_date'   => (!empty($end_date)?trim($end_date):date('Y-m-d')),
        );
        $data["reports"] = $this->global_model->read($data['search']);
        
        $this->mViewData['reports'] =  $data["reports"];
        $this->mViewData['search'] = $data['search'];
        $this->mTitle= lang('hosting_list');
        $this->render('domain/domain_report');
    }

    public function domainList(){
        $this->global_model->table = 'customer_domain';
        $list = $this->global_model->get_domain_datatables();

        $data = array();
        $no = $_POST['start'];
        $status = '';
        foreach ($list as $item) {
            if ($item->active == 1){
                $status = 'Active';
                $class = 'bg-olive-active';
            }else{
                $status = 'Expired';
                $class = 'bg-red-active';
            }
            $no++;
            $row = array();
            $row[] = '<a href="'.base_url('admin/customer/customerDetails').'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->customer_id)).'">'.$item->customer_name.'<br/><small>('.trim($item->contact_number).')</small></a>';
            $row[] = $item->company_name;
            $row[] = '<a href="'.base_url('admin/customer/customerDetails?tab=domain').'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->customer_id)).'">'.'<strong>'.$item->domain_name.'</strong></a>';
            $row[] = $this->localization->dateFormat($item->renewal_date);
            $row[] = '<span class="label '.$class.'">'.$status.'</span>';        
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->global_model->count_all(),
            "recordsFiltered" => $this->global_model->count_filtered_domain(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }



    function humanTiming ($time)
    {

        $time = time() - $time; // to get the time since that moment
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }

    }

    function change_status()
    {
        $id = $this->input->post('id');
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));

        if($id){

            $rating = $this->db->get_where('inbox', array(
                'id' => $id
            ))->row()->rating;

            if($rating){
                $data['rating'] = 0;
            }else{
                $data['rating'] = 1;
            }
            $this->db->where('id', $id);
            $this->db->update('inbox', $data);
        }
    }

    function viewEmail($id = null)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        $customer = $this->db->select('email')->get_where('customer', array('id' => $id))->row();
        $customer == TRUE || $this->message->norecord_found('admin/domain');
        $this->db->set('reading', 1, FALSE)->where('id', $id)->update('customer_domain');        
        $result = $this->db->get_where('customer_domain', array(
            'id' => $id
        ))->row();
        $this->mViewData['type'] =  'inbox';
        $this->mViewData['domain'] =  $result;
        $this->mViewData['customer'] =  $customer;
        $this->mTitle= lang('hosting_list');
        //$this->render('hosting/view_hosting');
        $this->render('domain/compose');
    }

    function composeMail()
    {
        $departments = $this->db->order_by('department', 'asc')->get('department')->result();
        $admin = $this->db->get('admin_users')->result();

        foreach($admin as $item)
        {
           $employee['admin'][] = (object)array(
                'id' => $item->id.'*A',
                'name' => $item->first_name.' '.$item->last_name ,
            );

        }

        foreach($departments as $item)
        {
           $result =  $this->db->get_where('employee', array(
                'department' => $item->id,
                'termination' => 1
            ))->result();

            foreach($result as $v_employee){
                $employee[$item->department][] = (object)array(
                    'id' => $v_employee->id.'*E',
                    'name' => $v_employee->first_name.' '.$v_employee->last_name ,
                );
            }

        }
        $this->mViewData['employee'] = $employee;

        $this->render('mail/compose');
    }

    function get_employee_by_department($id)
    {
        $department_id = $this->input->post('department_id');
        if($department_id == 'admin'){
            $employees = $this->db->get('admin_users')->result();
        }else{
            $employees = $this->db->get_where('employee', array('department' => $department_id ))->result();
        }

        if ($employees) {
            foreach ($employees as $item) {
                $HTML.="<option value='" . $item->id . "'>" . $item->first_name.' '.$item->last_name . "</option>";
            }
        }
        echo $HTML;
    }

    function sendEmail()
    {

       // $this->form_validation->set_rules('department', lang('select_department'), 'required');
        $this->form_validation->set_rules('employee_id[]', lang('employee'), 'required');
        $this->form_validation->set_rules('subject', lang('subject'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('msg', lang('message'), 'trim|required|xss_clean');


        if ($this->form_validation->run() == TRUE) {

            $attachment_id = mt_rand().'-'.date("Ymd-his");
            $sender = $this->ion_auth->user()->row();
            //inbox
            $to_employees    = $this->input->post('employee_id');
            $type            = $sender->type;
            $type            == 'admin' ? $data['from_type'] = 'admin': $data['from_type'] = 'employee';

            $data['sender_name'] = $sender->first_name.' '.$sender->last_name ;

            $data['subject'] = $this->input->post('subject');
            $data['msg'] = $this->input->post('msg');
            $data['from_emp_id'] = $this->ion_auth->user()->row()->id;
            $data['cc'] = json_encode($to_employees);
            $data['attachment_id'] = $attachment_id;

            $path = ATTACHMENT;
            mkdir_if_not_exist($path);
            $files = upload_attachment();
            $files = json_decode($files);
            $data['attachment'] = json_encode($files->success);

            foreach($to_employees as $to_id){
                $result = explode("*", $to_id);
                $data['to_emp_id'] = $result[0];
                $result[1]      == 'A' ? $data['to_type'] = 'admin': $data['to_type'] = 'employee';
                $this->db->insert('inbox', $data);
            }

            //outbox
            $outbox['from_emp_id'] = $this->ion_auth->user()->row()->id;
            $outbox['from_type'] = $data['from_type'];
            $outbox['cc'] = json_encode($to_employees);
            $outbox['subject'] = $this->input->post('subject');
            $outbox['msg'] = $this->input->post('msg');
            $outbox['attachment'] = json_encode($files->success);
            $outbox['attachment_id'] = $attachment_id;

            $this->db->insert('outbox', $outbox);

            $this->message->custom_success_msg('admin/mail/sentItem','Your Messages has benn send Successfully');
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/mail/composeMail', $error);
        }
    }
}