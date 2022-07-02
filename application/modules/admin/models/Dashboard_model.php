<?php
class Dashboard_model  extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }

    public function active_domain()
    {
        $this->db->select('*', false);
        $this->db->from('customer_domain');
        $this->db->where('active =', 1);
        $query_result = $this->db->get();
        $result = $query_result->result();
        $active = (object) array(
            'active'       => count($result),
        );

        return $active;
    }

    public function expired_domain()
    {
        $this->db->select('*', false);
        $this->db->from('customer_domain');
        $this->db->where('active =', 0);
        $query_result = $this->db->get();
        $result = $query_result->result();
        $expired = (object) array(
            'expired'       => count($result),
        );

        return $expired;
    }

    public function active_hosting()
    {
        $this->db->select('*', false);
        $this->db->from('customer_hosting');
        $this->db->where('active =', 1);
        $query_result = $this->db->get();
        $result = $query_result->result();
        $active = (object) array(
            'active'       => count($result),
        );

        return $active;
    }

    public function expired_hosting()
    {
        $this->db->select('*', false);
        $this->db->from('customer_hosting');
        $this->db->where('active =', 0);
        $query_result = $this->db->get();
        $result = $query_result->result();
        $expired = (object) array(
            'expired'       => count($result),
        );

        return $expired;
    }
    
    public function get_all_report_by_date($start_date, $end_date)
    {
        //sales
        $this->db->select('grand_total');
        $this->db->select_sum('grand_total');
        $this->db->from('sales_order');
        $this->db->where('date >=', $start_date);
        $this->db->where('date <=', $end_date.' '.'23:59:59');
        $this->db->where('type', 'Invoice');
        $this->db->where('status !=', 'Cancel');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;

    }

    public function get_today_sales()
    {
        $today = date("Y-m-d");
        $this->db->select('grand_total');
        $this->db->select_sum('grand_total');
        $this->db->from('sales_order');
        $this->db->where('date >=', $today);
        $this->db->where('date <=', $today.' '.'23:59:59');
        $this->db->where('type', 'Invoice');
        $this->db->where('status !=', 'Cancel');
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    public function get_weekly_sales()
    {
        $week_start_date = date('Y-m-d',strtotime("last Saturday"));
        $week_end_date = date('Y-m-d 23:59:59',strtotime("next Saturday"));

        $this->db->select('grand_total');
        $this->db->select_sum('grand_total');
        $this->db->from('sales_order');
        $this->db->where('date >=', $week_start_date);
        $this->db->where('date <=', $week_end_date);
        $this->db->where('type', 'Invoice');
        $this->db->where('status !=', 'Cancel');
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    public function get_monthly_sales()
    {
        $first_day_this_month = date('Y-m-01');
        $last_day_this_month  = date('Y-m-t');

        $this->db->select('grand_total');
        $this->db->select_sum('grand_total');
        $this->db->from('sales_order');
        $this->db->where('date >=', $first_day_this_month);
        $this->db->where('date <=', $last_day_this_month);
        $this->db->where('type', 'Invoice');
        $this->db->where('status !=', 'Cancel');
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result;
    }

    public function get_yearly_sales()
    {
        $year = date("Y");
        $this->db->select('grand_total');
        $this->db->select_sum('grand_total');
        $this->db->from('sales_order');
        $this->db->like('date', $year);
        $this->db->where('type', 'Invoice');
        $this->db->where('status !=', 'Cancel');
        $query_result = $this->db->get();
        $result = $query_result->row();

        return $result;
    }

    public function get_invoice_by_date($first_day_this_month, $last_day_this_month){
        $this->db->select('sales_order.*', false);
        $this->db->from('sales_order');
        $this->db->where('date >=', $first_day_this_month);
        $this->db->where('date <=', $last_day_this_month);
        $this->db->where('type', 'Invoice');
        $this->db->where('status !=', 'Cancel');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function get_top_selling_product($order_id){
        $this->db->select('product_id, product_name, SUM(qty) AS quantity ', false);
        $this->db->from('order_details');
        $this->db->where_in('order_id', $order_id);
        $this->db->group_by(array("product_id"));
        $this->db->order_by("quantity", "desc");
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;

    }

    public function recently_added_order()
    {
        $this->db->select('sales_order.*', false);
        $this->db->from('sales_order');
        $this->db->where('type', 'Invoice');
        $this->db->where('status !=', 'Cancel');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(6);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }


}