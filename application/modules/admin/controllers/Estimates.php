<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estimates extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('cart');
        $this->load->library('form_builder');
        $this->load->model('global_model');
        $this->load->model('estimates_model');
        $this->load->model('crud_model', 'crud');
        $this->load->library('grocery_CRUD');
        $this->mTitle = TITLE;
    }

    public function index()
	{
        $this->mViewData['totalEstimates'] = $this->estimates_model->total_estimates();
        $crud = new grocery_CRUD();
        //$crud = $this->generate_crud('sales_order');
        $crud->columns('date','id','customer_name','estimate_date','valid_until','grand_total','status', 'actions');
        $crud->order_by('id','desc');
        $crud->display_as('date', lang('date'));
        $crud->display_as('id', 'Estimate ID');
        $crud->display_as('customer_name', lang('customer'));
        $crud->display_as('estimate_date', 'Estimate Date');
        $crud->display_as('valid_until', 'Expiration Date');
        $crud->display_as('Total', lang('grand_total'));
        $crud->display_as('status','Status');
        $crud->display_as('actions', lang('actions'));
        $crud->set_table('estimates');
        $crud->callback_column('date',array($this->crud,'_callback_action_date'));
        $crud->callback_column('id',array($this->crud,'_callback_action_orderNo'));
        $crud->callback_column('customer_name',array($this->crud,'_callback_action_customer'));
        $crud->callback_column('estimate_date',array($this->crud,'_callback_action_estimateDate'));
        $crud->callback_column('valid_until',array($this->crud,'_callback_action_expiredDate'));
        $crud->callback_column('due_payment',array($this->crud,'_callback_action_due_payment'));
        $crud->callback_column('grand_total',array($this->crud,'_callback_action_grand_total'));
        $crud->callback_column('actions',array($this->crud,'_callback_action_all_estimate'));
        $crud->callback_column('status',array($this->crud,'_callback_action_estimate_status'));

        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_read();
        $this->mViewData['crud'] = $crud->render();
        $this->mTitle .= 'Estimate List';
        $this->render('estimates/index');
    }

    function newEstimates()
    {
        $this->mViewData['customers'] = $this->db->get('customer')->result();
        $this->mViewData['form'] = $this->form_builder->create_form('admin/estimates/save_estimates',true, array('id'=>'ss'));

        $categories = $this->db->order_by('category', 'asc')->get('product_category')->result();
        $this->mViewData['companies'] = $this->db->get('company')->result();
        if(!empty($categories)){
            foreach ($categories as $item){
                $tm_product = $this->db->order_by('name', 'asc')->get_where('product', array(
                    'category_id' => $item->id
                ))->result();

                if(!count($tm_product))
                    continue;

                $products[$item->category] = $tm_product;
            }
        }
        $this->mViewData['products'] = $products;
        $this->mViewData['title'] = 'Add New Estimate';
        $this->render('estimates/add_estimates');
    }

    function updateEstimate($estimateId = null){

        $this->cart->destroy();
        $estimateId = $estimateId - ESTIMATE_PRE;
        //query
        $this->mViewData['estimate'] = $this->db->get_where('estimates', array(
            'id' => $estimateId
        ))->row();

        if(!count($this->mViewData['estimate'])){
            redirect('admin/dashboard', 'refresh');
        }

        $this->mViewData['tax'] = $this->db->get('tax')->result();
        $this->mViewData['form'] = $this->form_builder->create_form('admin/estimates/update_save_estimates', true, array('id' => 'from-estimates'));

        //customer
        $this->mViewData['c_detail'] = $this->db->get_where('customer', array(
            'id' => $this->mViewData['estimate']->customer_id
        ))->row();

        //cart Operation
        $cartItem = json_decode($this->mViewData['estimate']->cart);
        foreach ($cartItem as $item ){
            $cart[] = array(
                'id'                => $item->id,
                'qty'               => $item->qty,
                'price'             => $item->price,
                'purchase_cost'     => $item->purchase_cost,
                'name'              => $item->name,
                'description'       => $item->description,
                'renewal_date'      => $item->renewal_date,
                'renewal_period'    => $item->renewal_period,
                'type'              => $item->type,
                'bundle'            => $item->bundle,
                'tax'               => $item->tax,
                'tax_id'            => $item->tax_id
            );
        }
        
        $this->cart->insert($cart);

        $s_data = array(
            'discount' => $this->mViewData['estimate']->discount,
            'gst' => $this->mViewData['estimate']->gst_tax,
            'cgst' => $this->mViewData['estimate']->cgst_tax,
            'sgst' => $this->mViewData['estimate']->sgst_tax,
            'igst' => $this->mViewData['estimate']->igst_tax,
            'amount_received' => $this->mViewData['estimate']->amount_received,
            'payment_method' => $this->mViewData['estimate']->payment_method,
            'p_reference' => $this->mViewData['estimate']->p_reference,
        );

        $this->session->set_userdata($s_data);
        $categories = $this->db->order_by('category', 'asc')->get('product_category')->result();
        $this->mViewData['companies'] = $this->db->get('company')->result();
        if(!empty($categories)){
            foreach ($categories as $item){
                $tm_product = $this->db->order_by('name', 'asc')->get_where('product', array(
                    'category_id' => $item->id
                ))->result();

                if(!count($tm_product))
                    continue;

                $products[$item->category] = $tm_product;
            }
        }

        $gst_tax = $this->db->get_where('billing_tax', array( 'tax' => 'GST' ))->result();
        $igst_tax = $this->db->get_where('billing_tax', array( 'tax' => 'IGST' ))->result();
        $cgst_tax = $this->db->get_where('billing_tax', array( 'tax' => 'CGST' ))->result();        
        $sgst_tax = $this->db->get_where('billing_tax', array( 'tax' => 'SGST' ))->result();

        $this->mViewData['gst_tax'] = $gst_tax;
        $this->mViewData['igst_tax'] = $igst_tax;
        $this->mViewData['sgst_tax'] = $sgst_tax;
        $this->mViewData['cgst_tax'] = $cgst_tax;

        $this->mViewData['products'] = $products;
        $this->mViewData['title'] = 'Edit Estimate';
        $this->render('estimates/add_estimates');
    }

    function update_save_estimates()
    {
        if(empty($this->cart->contents()))
            $this->message->custom_error_msg('admin/sales/allOrder', lang('sorry!_cart_is_empty'));
        $estimate_id = $this->input->post('estimate_id');
        $estimate_details = $this->db->get_where('estimates', array('id' => $estimate_id))->row();
        if(!count($estimate_details))
            redirect('admin/dashboard');

        $data['email']          = $this->input->post('email');
        $data['address']      = $this->input->post('address');
        $data['company_id']    = $this->input->post('company_id');
        $data['state']      = $this->input->post('state');
        $data['city']      = $this->input->post('city');

        
        $data['gst']      = $this->input->post('company_gst');
        $data['valid_until']       = date( "Y/m/d", strtotime( $this->input->post('valid_until') ) );
        $data['estimate_date']       = date( "Y/m/d", strtotime( $this->input->post('estimate_date') ) );
        $data['cart_total']     = $this->cart->total();
        $data['discount']       = (float)$this->session->userdata('discount');
        $data['gst_tax']       = (float)$this->session->userdata('gst');
        $data['cgst_tax']       = (float)$this->session->userdata('cgst');
        $data['sgst_tax']       = (float)$this->session->userdata('sgst');
        $data['igst_tax']       = (float)$this->session->userdata('igst');
        
        $total_tax = 0.00;
        foreach ($this->cart->contents() as $item) {
            $total_tax += $item['tax'];
        }
        $data['tax']     = $total_tax;
        $gtotal =  $this->cart->total();
        $discount = $this->session->userdata('discount');
        $discount_amount = ($gtotal * $discount)/100;
        $gst = $this->session->userdata('gst');
        $gst_amount = ($gtotal * $gst)/100; 
        $igst = $this->session->userdata('igst');
        $igst_amount = ($gtotal * $igst)/100; 
        $cgst = $this->session->userdata('cgst');
        $cgst_amount = ($gtotal * $cgst)/100; 
        $sgst = $this->session->userdata('sgst');
        $sgst_amount = ($gtotal * $sgst)/100;    
        $data['grand_total']    = $this->cart->total() + $total_tax + $gst_amount + $igst_amount + $cgst_amount + $sgst_amount - $discount_amount;
        $data['cart']           = json_encode($this->cart->contents());

        date_default_timezone_set(get_option('time_zone'));
        

        //old Cart Manipulate
        $old_cart = json_decode($estimate_details->cart,true);
        
        foreach ($this->cart->contents() as $n_item){
            foreach ($old_cart as $o_item)
            {
                if($n_item['id'] === $o_item['id']){
                    unset($old_cart[$o_item['rowid']]);
                }
            }
        }
        //update Order

        $this->db->where('id', $estimate_id);
        $this->db->update('estimates', $data);
        
        redirect('admin/estimates/preview/'.get_orderID($estimate_id));
    }

    function createPdfInvoice($id = null)
    {
        $id = $id - INVOICE_PRE;
        //query
        $data['estimate'] = $this->db->get_where('estimates', array(
            'id' => $id
        ))->row();

        if(!count($data['estimate'])){
            redirect('admin/dashboard', 'refresh');
        }
        
        $cart = json_decode($data['estimate']->cart);
        foreach ($cart as $item)
        {
            $estimate_details[] = (object)array(
                'product_name' => $item->name,
                'description' => $item->description,
                'price' => $item->price,
                'qty' => $item->qty,
            );
        }
        $data['estimate_details'] = $estimate_details;

        //customer
        $data['customer'] =    $this->db->select('customer.name,customer.id,customer.email,customer.phone_code, customer.phone_1,customer.address,customer.website,customer.state,customer.city, states.name as state_name, cities.name as city_name')
                ->from('customer')
                ->join('states', 'states.id = customer.state','left')
                ->join('cities', 'cities.id = customer.city','left')
                ->where('customer.id', $data['estimate']->customer_id)
                ->get()
                ->row();
        
        //company   
        $data['company'] =    $this->db->select('*')
                ->from('company')
                ->where('company.id', $data['estimate']->company_id)
                ->get()
                ->row();


        $file= ESTIMATE_PRE + $id;
        $filename = 'ESTIMATE#'. $file.'.pdf';
        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $html = $this->load->view('estimates/estimate_pdf', $data, true);
        
        $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
        $stylesheet = file_get_contents(FCPATH.'assets/css/invoice.css');
        
        
        $pdf->WriteHTML($stylesheet,1);
        $pdf->WriteHTML($html,2);
        $pdf->Output($filename, 'D');

    }

    function save_estimates()
    {
        if(empty($this->cart->contents()))
            $this->message->custom_error_msg('admin/estimates', lang('sorry!_cart_is_empty'));

        $estimate_id = $this->input->post('estimate_id');
        $data['website']      = $this->input->post('website');
        $data['gst']      = $this->input->post('company_gst');
        $data['email']          = $this->input->post('email');
        $data['address']      = $this->input->post('address');
        $data['state']      = $this->input->post('state');
        $data['city']      = $this->input->post('city');
        $data['estimate_date']   =  date( "Y-m-d", strtotime( $this->input->post('estimate_date') ) );

        $data['valid_until']       = date( "Y-m-d", strtotime( $this->input->post('valid_until') ) );
        $data['cart_total']     = $this->cart->total();
        $total_tax = 0.00;
        foreach ($this->cart->contents() as $item) {
             $total_tax += $item['tax'];
        }
        $data['tax']     = $total_tax;
        $gtotal =  $this->cart->total();
        $discount = $this->session->userdata('discount');
        $discount_amount = ($gtotal * $discount)/100;
        $gst = $this->session->userdata('gst');
        $gst_amount = ($gtotal * $gst)/100; 
        $igst = $this->session->userdata('igst');
        $igst_amount = ($gtotal * $igst)/100; 
        $cgst = $this->session->userdata('cgst');
        $cgst_amount = ($gtotal * $cgst)/100; 
        $sgst = $this->session->userdata('sgst');
        $sgst_amount = ($gtotal * $sgst)/100;    
        $data['grand_total']    = $this->cart->total() + $total_tax + $gst_amount + $igst_amount + $cgst_amount + $sgst_amount - $discount_amount;

        $data['cart']           = json_encode($this->cart->contents());
        //$data['type']           = ucwords($this->session->userdata('type'));


        if($estimate_id != ''){
            $data['status']         = 'draft';
        }else{
            $data['company_id']    = $this->input->post('company_id');
            $data['customer_id']    = $this->input->post('customer_id');
            $data['customer_name']  = $this->db->get_where('customer', array(
                'id' => $data['customer_id']
            ))->row()->name;
            $data['discount']       = (float)$this->session->userdata('discount');
            $data['gst_tax']       = (float)$this->session->userdata('gst');
            $data['cgst_tax']       = (float)$this->session->userdata('cgst');
            $data['sgst_tax']       = (float)$this->session->userdata('sgst');
            $data['igst_tax']       = (float)$this->session->userdata('igst');
        }

        date_default_timezone_set(get_option('time_zone'));
        if(empty($estimate_id)){
            $this->db->insert('estimates', $data);
            $estimate_id = $this->db->insert_id();
        }else{
            //update
            $this->db->where('id', $estimate_id);
            $this->db->update('estimates', $data);
        }

        $o_details['estimate_id'] = $estimate_id;
        redirect('admin/estimates/preview/'.$estimate_id);
    }

    
    function preview($id = null)
    {
        $id = $id - ESTIMATE_PRE;
        $this->mViewData['estimate'] = $this->db->get_where('estimates', array(
            'id' => $id
        ))->row();

        if(!count($this->mViewData['estimate'])){
            redirect('/', 'refresh');
        }

        $cart = json_decode($this->mViewData['estimate']->cart);
        foreach ($cart as $item)
        {
            $estimate_details[] = (object)array(
                'product_name' => $item->name,
                'description' => $item->description,
                'price' => $item->price,
                'qty' => $item->qty,
            );
        }
        $this->mViewData['estimate_details'] = $estimate_details;

        //customer
        $this->mViewData['customer'] = $this->db->select('customer.id,customer.name,customer.email,customer.phone_code, customer.phone_1,customer.address,customer.website,customer.state,customer.city, states.name as state_name, cities.name as city_name')
                ->from('customer')
                ->join('states', 'states.id = customer.state','left')
                ->join('cities', 'cities.id = customer.city','left')
                ->where('customer.id', $this->mViewData['estimate']->customer_id)
                ->get()
                ->row();
                
        $this->mTitle .= 'Estimate Invoice';
        $this->render('estimates/estimate_preview');
    }

    function sendEstimate($id = null)
    {
        $id = $id - INVOICE_PRE;
        $data['estimate'] = $this->db->get_where('estimates', array(
            'id' => $id
        ))->row();
        
        if(!count($data['estimate'])){
            redirect('admin/dashboard', 'refresh');
        }

        $cart = json_decode($data['estimate']->cart);
        foreach ($cart as $item)
        {
            $estimate_details[] = (object)array(
                'product_name' => $item->name,
                'description' => $item->description,
                'purchase_cost' => $item->purchase_cost,
                'estimates_cost' => $item->price,
                'qty' => $item->qty,
            );
        }
        $data['estimate_details'] = $estimate_details;

        //customer
        $data['customer'] = $this->db->get_where('customer', array(
            'id' => $data['estimate']->customer_id
        ))->row();
        
        //company   
        $data['company'] =    $this->db->select('*')
                ->from('company')
                ->where('company.id', $data['estimate']->company_id)
                ->get()
                ->row();
                
        $file= ESTIMATE_PRE + $id;
        $filename = 'ESTIMATE#'. $file.'.pdf';
        $this->load->library('pdf');
        $pdf = $this->pdf->load();

        $html = $this->load->view('estimates/estimate_pdf', $data, true);


        $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
        $stylesheet = file_get_contents(FCPATH.'assets/css/invoice.css');

        $pdf->WriteHTML($stylesheet,1);
        $pdf->WriteHTML($html,2);
        $pdfFilePath = FCPATH.'assets/invoice/'.$filename;


        ini_set('memory_limit','32M');
        //$pdf->Output($filename, 'D');
        $pdf->Output($pdfFilePath, 'f');

        $data['file_name'] = $filename;
        $data['file_path'] = $pdfFilePath;
        $data['modal_subview'] = $this->load->view('admin/estimates/modal/_send_email',$data, FALSE);
        $this->load->view('admin/_partials/_layout_modal', $data);
    }

    function deleteEstimate($id = null)
    {
        $id = $id - INVOICE_PRE;
        $estimate = $this->db->get_where('estimates', array('id' => $id ))->row();
        $this->db->delete('estimates', array('id' => $estimate->id));
        $this->message->delete_success('admin/estimates');
    }

    function sendEmail()
    {
        $id = $this->input->post('id');
        $mailType = get_option('email_send_option');
        if($mailType == 'smtp')
        {
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => get_option('smtp_host'),
                'smtp_port' => get_option('smtp_port'),
                'smtp_user' => get_option('smtp_username'),
                'smtp_pass' => get_option('smtp_password'),
                'mailtype'  => 'html',
                'charset'   => 'iso-8859-1'
            );
            $this->load->library('email', $config);

            $to_list = $this->input->post('to');

            $this->email->from(get_option('all_other_mails_from'), get_option('mail_sender'));
            $this->email->to($to_list);

            $this->email->subject($this->input->post('subject'));
            $this->email->message($this->input->post('msg'));
            $this->email->attach($this->input->post('filepath'));

            if ($this->email->send())
            {
                $data['status'] = 'sent';
                $this->db->where('id', $id);
                $this->db->update('estimates', $data);
                $this->message->custom_success_msg('admin/estimates/preview/'.get_orderID($id), lang('your_email_has_been_send_successfully!'));
            }else{
                $this->message->custom_error_msg('admin/estimates/preview/'.get_orderID($id), lang('fail_to_send_your_email'));
            }
        }else{
            $this->message->custom_error_msg('admin/estimates/preview/'.get_orderID($id), lang('fail_to_send_your_email'));
        }
    }

    //------------------------------------------------------------------------------------------------------------
    //************************* Add to cart *****************************************************************
    //------------------------------------------------------------------------------------------------------------


    function add_to_cart()
    {
        $id = $this->input->post('product_id');
        $product = $this->db->get_where('product', array( 'id' => $id ))->row();
        if(!empty($this->input->post('rowid'))){
            $data = array(
                'rowid' => $this->input->post('rowid'),
                'qty'   => 0
            );
            $this->cart->update($data);
        }

        if(count($product)){
            $data = array(
                'id'                => $product->id,
                'qty'               => 1,
                'price'             => $product->sales_cost,
                'purchase_cost'     => $product->buying_cost,
                'name'              => $product->name,
                'description'       => $product->sales_info,
                'type'              => FALSE,
                'tax'            => '',
                'tax_id'        =>''
            ); 
            $this->cart->insert($data);
        }
    }

    /*** Product tax calculation ***/
    public function product_tax_calculate($tax_id, $qty ,$price)
    {
        $tax = $this->db->get_where('tax', array('id' => $tax_id ))->row();

        if($tax){
            if($tax->type == 1)
            {
                $subtotal = $price * $qty;
                $product_tax = ($tax->rate * $subtotal) / 100;
                return $result = $product_tax;

            }else
            {
                $product_tax = $tax->rate * $qty;
                return $result = $product_tax;
            }
        }
    }

    function update_cart_item()
    {
        $type = $this->input->post('type');
        //product tax check
        $product = $this->db->get_where('product', array( 'id' => $this->input->post('p_id') ))->row();
        $qty = $this->input->post('qty');
        $price = $this->input->post('price');
        $tax_id = $this->input->post('tax');
        
        $tax = $this->product_tax_calculate($tax_id, $qty, $price);
        
        if($type === 'qty')
        {
            $data = array(
                'rowid' => $this->input->post('rowid'),
                'qty'   => (int)$this->input->post('o_val'),
                'tax'   => '',
                'tax_id' => '',
            );
        }
        elseif ($type === 'prc'){
            $data = array(
                'rowid' => $this->input->post('rowid'),
                'price'   => (float)$this->input->post('o_val'),
                'tax'   => '',
                'tax_id' => '',
            );
        }elseif ($type === 'tax'){
            $data = array(
                'rowid' => $this->input->post('rowid'),
                'tax'   => '',
                'tax_id' => '',
            );
        }elseif ($type === 'des'){
            $data = array(
                'rowid' => $this->input->post('rowid'),
                'description'   => $this->input->post('o_val')
            );
        }

        $this->cart->update($data);
    }

    function remove_item(){
        $data = array(
            'rowid' => $this->input->post('rowid'),
            'qty'   => 0
        );
        $this->cart->update($data);
    }

    function show_cart(){
        $categories = $this->db->order_by('category', 'asc')->get('product_category')->result();
        $gst_tax = $this->db->get_where('billing_tax', array( 'tax' => 'GST' ))->result();
        $igst_tax = $this->db->get_where('billing_tax', array( 'tax' => 'IGST' ))->result();
        $cgst_tax = $this->db->get_where('billing_tax', array( 'tax' => 'CGST' ))->result();
        $sgst_tax = $this->db->get_where('billing_tax', array( 'tax' => 'SGST' ))->result();

        if(!empty($categories)){
            foreach ($categories as $item){
                $tm_product = $this->db->order_by('name', 'asc')->get_where('product', array(
                    'category_id' => $item->id
                ))->result();

                if(!count($tm_product))
                    continue;

                $products[$item->category] = $tm_product;
            }
        }
        $data['tax'] = $this->db->get('tax')->result();
        $data['products'] = $products;
        $data['gst_tax'] = $gst_tax;
        $data['igst_tax'] = $igst_tax;
        $data['cgst_tax'] = $cgst_tax;
        $data['sgst_tax'] = $sgst_tax;
        $this->load->view('estimates/add_product_cart',$data);
    }

    function order_discount()
    {
        $discount = (float)$this->input->post('discount');
        if(!empty($discount)){
            $data = array(
                'discount' => $discount
            );
        }else{
            $data = array(
                'discount' => 0
            );
        }
        $this->session->set_userdata($data);
    }

     // GST Calculate Function //
     public function taxGSTCalculate()
     {
         $gst = (float)$this->input->post('gst');
         if(!empty($gst)){
             $data = array(
                 'gst' => $gst
             );
         }else{
             $data = array(
                 'gst' => 0
             );
         }
         $this->session->set_userdata($data);
     }
 
     public function taxCGSTCalculate()
     {
         $cgst = (float)$this->input->post('cgst');
         if(!empty($cgst)){
             $data = array(
                 'cgst' => $cgst
             );
         }else{
             $data = array(
                 'cgst' => 0
             );
         }
         $this->session->set_userdata($data);
     }
 
     public function taxIGSTCalculate(){
         $igst = (float)$this->input->post('igst');
         if(!empty($igst)){
             $data = array(
                 'igst' => $igst
             );
         }else{
             $data = array(
                 'igst' => 0
             );
         }
         $this->session->set_userdata($data);
     }
 
     public function taxSGSTCalculate(){
         $sgst = (float)$this->input->post('sgst');
         if(!empty($sgst)){
             $data = array(
                 'sgst' => $sgst
             );
         }else{
             $data = array(
                 'sgst' => 0
             );
         }
         $this->session->set_userdata($data);
     }
}