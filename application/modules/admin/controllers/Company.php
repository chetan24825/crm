<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->load->model('global_model');
        $this->load->model('crud_model', 'crud');
        $this->load->model('report_model', 'report');
        $this->load->model('attendance_model');
        $this->load->library('grocery_CRUD');
        $this->mTitle = TITLE;
    }

    function index()
    {
        $this->mViewData['modal'] = FALSE;
        $this->mTitle= lang('company');
        $this->render('company/company_list');
    }

    public function company_list()
    {
        $this->global_model->table = 'company';
        $this->global_model->column_order = array('company','description',null);
        $this->global_model->column_search = array('company','description');
        $this->global_model->order = array('id' => 'desc');

        $list = $this->global_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->company;
            $row[] = $item->description;

            //add html for action
            $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" href="javascript:void(0)" onclick="edit_title('."'".$item->id."'".')"><i class="fa fa-pencil"></i></a>
				  <a class="btn btn-xs btn-danger" href="javascript:void(0)"  onclick="deleteItem('."'".$item->id."'".')"><i class="glyphicon glyphicon-trash"></i></a></div>';
            $data[] = $row;
        }
        $this->global_model->render_table($data);
    }

    public function edit_company($id)
    {
        $this->global_model->table = 'company';
        $data = $this->global_model->get_by_id($id);
        echo json_encode($data);
    }

    public function add_company()
    {
        $this->global_model->table = 'company';
        $this->_company_validate();
        $data = array(
            'company' => $this->input->post('company'),
            'company_address' => $this->input->post('address'),
            'company_gst' => $this->input->post('company_gst'),

        );
        $insert = $this->global_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function update_company()
    {
        $this->global_model->table = 'company';
        $this->_company_validate();
        $data = array(
            'company' => $this->input->post('company'),
            'bankinfo' => $this->input->post('bankinfo'),
            'paytm' => $this->input->post('paytm'),
            'googlepay' => $this->input->post('googlepay'),
            'company_address' => $this->input->post('address'),
            'company_gst' => $this->input->post('gst'),
        );
        $this->global_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete_company($id)
    {
        $this->global_model->table = 'company';

        $result = $this->db->get_where('employee', array('company' => $id ))->result();

        if(empty($result)){
            $this->global_model->delete_by_id($id);
            echo 1;
        }else{
            echo 0;
        }

    }

    private function _company_validate()
    {
        $rules = array(
            array('field'=>'company', 'label'=> lang('company'), 'rules'=>'trim|required'),
            array('field'=>'address', 'label'=> lang('address'), 'rules'=>'trim|required'),
        );

        $this->global_model->validation($rules);
    }
}