<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Location Controller FrontEnd
 *
 * @author Jaeeme
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Location extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('global_model');
    }

    // get state names
    public function index() {
        $data['page'] = 'country-list';
        $data['title'] = 'country List | TechArise';
        $data['geCountries'] = $this->global_model->getAllCountries();   
        $this->load->view('global_model/index', $data);
    }

    // get state names
    public function getstates() {
        $json = array();
        $this->global_model->setCountryID($this->input->post('countryID'));
        $json = $this->global_model->getStates();
        header('Content-Type: application/json');
        echo json_encode($json);
    }

    // get city names
    function getcities() {
        $json = array();
        $this->global_model->setStateID($this->input->post('stateID'));
        $json = $this->global_model->getCities();
        header('Content-Type: application/json');
        echo json_encode($json);
    }

}
?>