<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Admin_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->mTitle = TITLE;
		$this->load->model('dashboard_model');
	}

	public function index()
	{
		//$this->load->model('user_model', 'users');
		$this->mViewData['active_domain'] = $this->dashboard_model->active_domain();
		$this->mViewData['expired_domain'] = $this->dashboard_model->expired_domain();
		$this->mViewData['active_hosting'] = $this->dashboard_model->active_hosting();
		$this->mViewData['expired_hosting'] = $this->dashboard_model->expired_hosting();
		
		$this->mViewData['year'] = date('Y');
        //===================Sales Report ===========================>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

        $year = date('Y');
        $this->mViewData['year'] = $year;
        // get yearly report
        $this->mViewData['yearly_sales_report'] = $this->get_yearly_sales_report($year);

        //get today sell
        $this->mViewData['today_sale'] = $this->dashboard_model->get_today_sales();
        //weekly Sales Report
        $this->mViewData['weekly_sales'] = $this->dashboard_model->get_weekly_sales();
        //Monthly Sales Report
        $this->mViewData['monthly_sales'] = $this->dashboard_model->get_monthly_sales();
        //get this year sales
        $this->mViewData['yearly_sale'] = $this->dashboard_model->get_yearly_sales();

        //top 5 selling Product
        $first_day_this_year = date('Y-01-01');
        $last_day_this_year  = date('Y-12-31');

        $yearlyInvoiceList = $this->dashboard_model->get_invoice_by_date($first_day_this_year, $last_day_this_year);

        //best selling Product this year
        if(count($yearlyInvoiceList)){
            $order_id = array();
            foreach($yearlyInvoiceList as $item ) {
                $order_id[] = $item->id;
            }

            $this->mViewData['top_sell_product'] = $this->dashboard_model->get_top_selling_product($order_id);
        }

        //top 5 sell on this month
        $first_day_this_month = date('Y-m-01');
        $last_day_this_month  = date('Y-m-t');

        $invoiceList = $this->dashboard_model->get_invoice_by_date($first_day_this_month, $last_day_this_month);


        //best selling Product this year
        if(count($invoiceList)){
            $order_id = array();
            foreach($invoiceList as $item ) {
                $order_id[] = $item->id;
            }

            $this->mViewData['top_sell_product_month'] = $this->dashboard_model->get_top_selling_product($order_id);
        }

        // recent order
        $this->mViewData['order_info'] = $this->dashboard_model->recently_added_order();


		$this->mTitle .= lang('dashboard');
		$this->render('home');
	}

    /*** Get Yearly Report ***/
    public function get_yearly_sales_report($year)
    {

        for ($i = 1; $i <= 12; $i++) {
            if ($i >= 1 && $i <= 9) {
                $start_date = $year.'-'.'0'.$i.'-'.'01';
                $end_date = $year.'-'.'0'.$i.'-'.'31';
            } else {
                $start_date = $year.'-'.$i.'-'.'01';
                $end_date = $year.'-'.$i.'-'.'31';
            }
            $get_all_report[$i] = $this->dashboard_model->get_all_report_by_date($start_date, $end_date);

        }

        return $get_all_report;
    }


    public function get_yearly_transaction_report($year)
	{

		for ($i = 1; $i <= 12; $i++) {
			if ($i >= 1 && $i <= 9) {
				$start_date = $year.'-'.'0'.$i.'-'.'01';
				$end_date = $year.'-'.'0'.$i.'-'.'31';
			} else {
				$start_date = $year.'-'.$i.'-'.'01';
				$end_date = $year.'-'.$i.'-'.'31';
			}
			$get_all_report[$i] = $this->dashboard_model->get_all_transaction_by_date($start_date, $end_date);

		}
		return $get_all_report;
	}

	function getEvent()
	{

		//$result = $this->db->get('events')->result_array();
		$result = $this->db->get_where('events', array(
				'employee_id' 	=> $this->ion_auth->user()->row()->id,
				'type'			=> 'A'
		))->result_array();
		echo json_encode($result);
	}

	function addEvent()
	{

		$data['title'] = $this->input->post('title');

		$data['start'] 			= $this->input->post('start').' '.$this->input->post('startTime');
		$data['end'] 			= $this->input->post('end').' '.$this->input->post('endTime');
		$data['color'] 			= $this->input->post('color');
		$data['employee_id'] 	= $this->ion_auth->user()->row()->id;
		$data['type'] 			= 'A';

		$this->db->insert('events', $data);

		return true;

		//header('Location: '.$_SERVER['HTTP_REFERER']);
	}

	function editEventDate()
	{
		$id = $_POST['Event'][0];
		$data['start'] = $_POST['Event'][1];
		$data['end'] = $_POST['Event'][2];

		$this->db->where('id', $id);
		$this->db->update('events', $data);

		return true;
	}

	function edit_event()
	{


		$id = $this->input->post('id');
		$delete = $this->input->post('delete');

		if(isset($delete)){
			$this->db->delete('events', array('id' => $id));
			return true;
		}
		$data['title'] = $this->input->post('title');
		$data['start'] = $this->input->post('start').' '.$this->input->post('startTime');
		$data['end'] = $this->input->post('end').' '.$this->input->post('endTime');
		$data['color'] = $this->input->post('color');

		//update
		$this->db->where('id', $id);
		$this->db->update('events', $data);

		return true;
	}

}
