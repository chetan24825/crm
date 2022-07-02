<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hosting extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('global_model');
        $this->load->library('form_builder');
    }

    function index()
    {
        $data['search'] = (object)array(
            'filter'     => trim($this->input->get('filter')),
            'start_date' => (!empty($start_date)?trim($start_date):date('d-m-Y')),
            'end_date'   => (!empty($end_date)?trim($end_date):date('d-m-Y')),
        );
        $this->mTitle= lang('hosting_list');
        $this->mViewData['search'] = $data['search'];
        $this->render('hosting/inbox');
    }

    public function hostingList(){
        $this->global_model->table = 'customer_hosting';
        $list = $this->global_model->get_hosting_datatables();

        $data = array();
        $no = $_POST['start'];
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
            $row[] = '<a href="'.base_url('admin/customer/customerDetails?tab=domain').'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->customer_id)).'">'.'<strong>'.$item->hosting_company.'</strong> - ('.$item->hosting_space.')</a>';
            $row[] = $this->localization->dateFormat($item->renewal_date);
            $row[] = '<span class="label '.$class.'">'.$status.'</span>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->global_model->count_all(),
            "recordsFiltered" => $this->global_model->count_filtered_hosting(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
}