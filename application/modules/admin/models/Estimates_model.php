<?php
class Estimates_model  extends CI_Model
{
    private $table = null;

    function __construct() {
        $this->table = 'estimates';
        parent::__construct($this->table);
    }

    public function total_estimates($customer_id='')
    {
        $this->db->select('*', false);
        $this->db->from('estimates');
        if($customer_id != '') {
            $this->db->where('customer_id', $customer_id);
        }
        $query_result = $this->db->get();
        $result = $query_result->result();

        $total_estimate = 0;
        foreach ($result as $item){
            $total_estimate += $item->grand_total;
        }

        $estimate = (object) array(
            'invoice_qty'       => count($result),
            'estimate_amount'    => $total_estimate,
        );

        return $estimate;
    }

}