<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->mTitle = TITLE;
        ini_set('max_input_vars', '3000');
        $this->load->model(array('settings_model','global_model'));
    }


    function index()
    {
        $form[0] = $this->form_builder->create_form();
        $tab = $this->input->get('tab');
        $tabView = explode("/", $tab);
        //$data = [];
        if(!$this->input->get('tab'))
        {
            $view   = 'company';
            $tab    = 'company';
           // $data   = '';
        }else{
            $tab    = $tabView[0];
            $view   = $tabView[0];
            //$data   = '';
        }

        if($tabView[0]=='localization')
        {
            $data['countries']                  = $this->db->get('countries')->result();
            $data['timezones']                  = $this->settings_model->timezones();
        }
        
        $data['form']                           = $form[0];
        $data['tab']                            = $tab;
        $this->mViewData['form'] = $form;
        $this->mViewData['tab']                 = $tab;
        $this->mViewData['tab_view']            = $this->load->view('admin/settings/includes/'.$view,$data,true);
        $this->mTitle.= lang('system_settings');;
        $this->render('settings/all');
    }

    public function edit_translations($lang) {

        $path = array($lang . "_lang.php" => "./system/language/");

        $data['current_languages'] = $lang;
        $data['english'] = $this->lang->load('general', 'english', TRUE);

        if ($lang == 'english') {
            $data['translation'] = $data['english'];
        } else {
            $data['translation'] = $this->lang->load($lang, $lang, TRUE, TRUE);
        }

        $view = 'translation';
        $data['language_files'] = $lang;
        $this->mTitle.= 'Edit Translation';
        $this->mViewData['tab']                        =  'language';
        $this->mViewData['tab_view']                   =  $this->load->view('admin/settings/includes/'.$view,$data,true);
        $this->render('settings/all');
    }

    public function set_translations() {
        $lang = $this->input->post('language');
        $this->settings_model->save_translation($lang);
        $this->message->save_success('admin/settings?tab=language/translation/'.$lang);
        //redirect('admin/settings?tab=language/translation/'.$lang);

    }

    function language_status($language)
    {
       $result =  $this->db->get_where('language', array( "name" => $language))->row();
       if($result)
       {
           $data['active'] = 0;
           $id = $this->db->get_where('language', array( "active" => 1))->row()->id;
           $this->db->set('active', 0, FALSE)->where('id', $id)->update('language');
           $this->db->set('active', 1, FALSE)->where('name', $language)->update('language');

           // check with available options inside: application/config/language.php

           // save selected language to session
           $this->session->set_userdata('language', $language);
           $this->load->library('user_agent');

           $this->message->save_success('admin/settings?tab=language');
       }else{
           $this->message->norecord_found('admin/settings?tab=language');
       }
    }


//   ============== End Multi Language ==================================== //

    function save_settings()
    {

        $settings   = $this->input->post('settings');
        $tab        = $this->input->post('tab');

        if(!empty($settings))
        {
            // Loop through hotels and add the validation
            foreach($settings as $id => $data)
            {
                //$name = ucfirst(str_replace('_',' ',$id));
                $this->form_validation->set_rules('settings[' . $id . ']', lang($id), 'required|trim');

            }
        }


        if ($this->form_validation->run() == FALSE)
        {
            // Errors
            $error = validation_errors();

            $this->message->custom_error_msg('admin/settings?tab='.$tab ,$error);
        }
        else
        {
            // Success
            handel_upload_logo();
            handel_upload_icon();
            handel_upload_invoice_logo();
            handel_upload_login_logo();
            foreach ($settings as $name => $val) {
                // Check if the option exists
                $this->db->where('name', $name);
                $exists = $this->db->count_all_results('options');

                if ($exists == 0) {
                    //continue;
                    $this->db->insert('options', array(
                        'name' => $name
                    ));
                }

                $this->db->where('name', $name);
                $this->db->update('options', array(
                    'value' => $val
                ));
            }
        }
        $this->message->save_success('admin/settings?tab='.$tab);

    }

    function remove($prm)
    {
        $file = $this->db->get_where('options', array( "name" => $prm ))->row();
        $file = UPLOAD_LOGO.$file->value;
        if (!unlink($file))
        {
            //error
            $this->message->custom_error_msg('admin/settings?tab=company',"Error deleting $file");
        }
        else
        {
            //success
            $this->db->where('name', $prm);
            $this->db->update('options', array(
                'value' => ''
            ));
            $this->message->delete_success('admin/settings?tab=company');
        }
    }

    function billing_tax()
    {
        $this->mViewData['modal'] = FALSE;
        $this->mTitle= 'Billing Tax';
        $this->render('settings/billing_tax');
    }

    public function add_billing_tax()
    {
        $this->global_model->table = 'billing_tax';
        $this->_tax_validate();
        $data = array(
            'tax' => $this->input->post('name'),
            'type' => $this->input->post('type'),
            'rate' => (float)$this->input->post('rate'),

        );
        $insert = $this->global_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function edit_billing_tax($id)
    {
        $this->global_model->table = 'billing_tax';
        $data = $this->global_model->get_by_id($id);
        echo json_encode($data);
    }

    public function update_billing_tax()
    {
        $this->global_model->table = 'billing_tax';
        $this->_tax_validate();
        $data = array(
            'tax' => $this->input->post('name'),
            'type' => $this->input->post('type'),
            'rate' => $this->input->post('rate')
        );
        $this->global_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    function delete_billing_tax($id=null){
        if(!empty($id)){
            $this->db->delete('billing_tax', array('id' => $id));
            echo json_encode(array("status" => TRUE));
        }else{
            echo json_encode(array("status" => FALSE));
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
    
    public function billing_tax_list()
    {
        $this->global_model->table = 'billing_tax';
        $this->global_model->column_order = array('tax','rate','type',null);
        $this->global_model->column_search = array('tax','rate','type');
        $this->global_model->order = array('id' => 'desc');

        $list = $this->global_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $item->tax;
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
}