<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->mTitle = TITLE;
        ini_set('max_input_vars', '3000');
        $this->load->model('settings_model');
        $this->load->model('global_model');
    }


    function index()
    {
        $this->mViewData['modal'] = FALSE;
        $this->mTitle= lang('tax');
        $this->render('tax/tax');
    }

    public function tax_list()
    {
        $this->global_model->table = 'tax';
        $this->global_model->column_order = array('name','rate','type',null);
        $this->global_model->column_search = array('name','rate','type');
        $this->global_model->order = array('id' => 'desc');

        $list = $this->global_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->name;
            $row[] = $item->rate;
            $type = $item->type==1? lang('percentage'): lang('fixed');
            $row[] = $type;

            //add html for action
            $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" href="javascript:void(0)" onclick="edit_title('."'".$item->id."'".')"><i class="fa fa-pencil"></i></a>
				  <a class="btn btn-xs btn-danger" href="javascript:void(0)"  onclick="deleteItem('."'".$item->id."'".')"><i class="glyphicon glyphicon-trash"></i></a></div>';
            $data[] = $row;
        }
        $this->global_model->render_table($data);
    }


    public function edit_tax($id)
    {
        $this->global_model->table = 'tax';
        $data = $this->global_model->get_by_id($id);
        echo json_encode($data);
    }

    public function add_tax()
    {
        $this->global_model->table = 'tax';
        $this->_tax_validate();
        $data = array(
            'name' => $this->input->post('name'),
            'type' => $this->input->post('type'),
            'rate' => (double)$this->input->post('rate'),

        );
        $insert = $this->global_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function update_tax()
    {
        $this->global_model->table = 'tax';
        $this->_tax_validate();
        $data = array(
            'name' => $this->input->post('name'),
            'type' => $this->input->post('type'),
            'rate' => (double)$this->input->post('rate'),
        );
        $this->global_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function tax_department($id)
    {
        $this->global_model->table = 'tax';

        $result = $this->db->get_where('tax', array('id' => $id ))->result();

        if(empty($result)){
            $this->global_model->delete_by_id($id);
            echo 1;
        }else{
            echo 0;
        }

    }


    private function _tax_validate()
    {
        $rules = array(
            array('field'=>'name', 'label'=> lang('name'), 'rules'=>'trim|required'),
            array('rate'=>'rate', 'label'=> lang('rate'), 'rules'=>'trim|required'),
        );

        $this->global_model->validation($rules);
    }



}