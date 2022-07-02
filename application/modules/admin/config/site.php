<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Site (by CI Bootstrap 3)
| -------------------------------------------------------------------------
| This file lets you define default values to be passed into views when calling 
| MY_Controller's render() function. 
|
| Each of them can be overrided from child controllers.
|
*/

//$this->CI =& get_instance();


$CI = & get_instance();
$CI->load->database();
if ($CI->db->database != '') {
    $lang = $CI->db->get_where('language', array("active" => 1))->row()->name;
}
if(empty($lang))
{
    $lang = 'english';
}
$CI->lang->load($lang.'_menu', $lang,$lang );



$config['site'] = array(

    // Site name
    'name' => 'Admin Panel',

    // Default page title
    // (set empty then MY_Controller will automatically generate one based on controller / action)
    'title' => '',

    // Default meta data (name => content)
    'meta'	=> array(
        'author'		=> 'Codes Lab (www.codeslab.net)',
        'description'	=> 'eOffice Manager'
    ),

    // Default scripts to embed at page head / end
    'scripts' => array(
        'head'	=> array(
            'assets/js/jQuery-2.2.0.min.js',            
            'assets/js/bootstrap.min.js',
        ),
        'foot'	=> array(
            'assets/js/popper.min.js',
            'assets/js/plugins/metisMenu/jquery.metisMenu.js',
            'assets/js/inspinia.js',
            'assets/js/plugins/pace/pace.min.js',
            'assets/plugin/select2/select2.full.min.js',
            'assets/plugin/input-mask/jquery.inputmask.js',
            'assets/plugin/input-mask/jquery.inputmask.date.extensions.js',
            'assets/plugin/input-mask/jquery.inputmask.extensions.js',
            'assets/plugin/daterangepicker/moment.min.js',
            'assets/plugin/daterangepicker/daterangepicker.js',
            'assets/plugin/datepicker/bootstrap-datepicker.js',
            'assets/plugin/colorpicker/bootstrap-colorpicker.min.js',
            'assets/plugin/timepicker/bootstrap-timepicker.min.js',
            'assets/plugin/slimScroll/jquery.slimscroll.min.js',
            'assets/plugin/fastclick/fastclick.js',
            'assets/js/app.min.js',
            'assets/js/admin.js',
            'assets/js/cart.js',
            'assets/js/jquery.PrintArea.js',
            'assets/js/printThis.js',
            'assets/js/ckeditor.js',
            'assets/plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
            //data tables
            'assets/plugin/datatables/jquery.dataTables.min.js',
            'assets/plugin/datatables/dataTables.bootstrap.js',
            'assets/plugin/datatables/dataTables.buttons.min.js',
            'assets/plugin/datatables/buttons.bootstrap.min.js',
            'assets/plugin/datatables/jszip.min.js',
            'assets/plugin/datatables/pdfmake.min.js',
            'assets/plugin/datatables/vfs_fonts.js',
            'assets/plugin/datatables/buttons.html5.min.js',
            'assets/plugin/datatables/buttons.print.min.js',
            'assets/plugin/datatables/dataTables.fixedHeader.min.js',
            'assets/plugin/datatables/dataTables.keyTable.min.js',
            'assets/plugin/datatables/dataTables.responsive.min.js',
            'assets/plugin/datatables/responsive.bootstrap.min.js',
            'assets/plugin/datatables/dataTables.scroller.min.js',

            //form validation
            'assets/plugin/jquery-validation/jquery.validate.min.js',
            'assets/plugin/jquery-validation/additional-methods.min.js',
            'assets/js/forms_validation.js',
            'assets/js/jquery.chained.js',
        ),
    ),

    'stylesheets' => array(
        'screen' => array(            
            'assets/css/bootstrap/css/bootstrap.css',
            'assets/plugin/select2/select2.min.css',
            'assets/font-awesome/css/font-awesome.css',
            'assets/css/plugins/toastr/toastr.min.css',
            'assets/css/AdminLTE.css',
            'assets/css/animate.css',
            'assets/css/style.css',
            'assets/plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
            //data tables
            'assets/plugin/datatables/jquery.dataTables.min.css',
            'assets/plugin/datatables/buttons.bootstrap.min.css',
            'assets/plugin/datatables/fixedHeader.bootstrap.min.css',
            'assets/plugin/datatables/responsive.bootstrap.min.css',
            'assets/plugin/datatables/scroller.bootstrap.min.css',
            'assets/plugin/datepicker/datepicker3.css',
        )
    ),


    // Multilingual settings (set empty array to disable this)
    'multilingual' => array(),

    // AdminLTE settings
    'adminlte' => array(
        'admin'		    => array('skin' => 'skin-purple'),
    ),

    // Menu items which support icon fonts, e.g. Font Awesome
    // (or directly update view file: /application/modules/admin/views/_partials/sidemenu.php)
    'menu' => array(
        'home' => array(
            'name'		=> $CI->lang->line('dashboard'),
            'url'		=> 'home',
            'icon'		=> 'dashboard',
        ),

        'sales' => array(
            'name'		=> $CI->lang->line('sales'),
            'url'		=> 'sales',
            'icon'		=> 'shopping_basket',
            'children'  => array(
                $CI->lang->line('create_invoice')	        => 'sales/type/invoice',
                $CI->lang->line('all_invoice')	        => 'sales/allOrder',
            )
        ),

        'customer' => array(
            'name'		=> $CI->lang->line('customer'),
            'url'		=> 'customer',
            'icon'		=> 'people_outline',
            'children'  => array(
                $CI->lang->line('add_new_customer')	=> 'customer/newCustomer',
                $CI->lang->line('customer_list')	=> 'customer/customerList',
            )
        ),

        'packages' => array(
            'name'		=> 'Packages',
            'url'		=> 'packages',
            'icon'		=> 'archive',
        ),
       
        'panel' => array(
            'name'		=> 'Admin User',
            'url'		=> 'panel',
            'icon'		=> 'group',
            'children'  => array(
                $CI->lang->line('manage_user')		=> 'panel/admin_list',
                $CI->lang->line('create_user')		=> 'panel/admin_user_create',
            )
        ),

        'setting' => array(
            'name'		=> $CI->lang->line('settings'),
            'url'		=> 'settings',
            'icon'		=> 'settings',
        ),
    ),

    // default page when redirect non-logged-in user
    'login_url' => 'admin/login',

    // restricted pages to specific groups of users, which will affect sidemenu item as well
    // pages out of this array will have no restriction (except required admin user login)
    'page_auth' => array(

        //Admin User Menu Permission
        'panel'									=> array('admin'),
        'panel/admin_list'						=> array('admin'),
        'panel/admin_user_create'				=> array('admin'),
        'panel/admin_user_reset_password'		=> array('admin'),
        'panel/update_profile'					=> array('admin'),
        'panel/delete_employee'					=> array('admin'),

        //Settings Menu Permission
        'settings'								=> array('admin'),

        //franchise Menu Permission
        'franchise'								=> array('admin'),
        'franchise/franchiseList'				=> array('admin'),
        'franchise/franchiseDetails'				=> array('admin'),

        //sales
        'sales'									=> array('admin','accounts','sales'),
        'estimates'									=> array('admin','accounts','sales'),
        'sales/type/invoice'					=> array('admin','accounts','sales'),
        'sales/allOrder'					    => array('admin','accounts','sales'),
        'sales/processing'					    => array('admin','accounts','sales'),
        'sales/pending'					        => array('admin','accounts','sales'),
        'sales/deliveredOrder'					=> array('admin','accounts','sales'),
        'sales/type/quotation'					=> array('admin','accounts','sales'),
        'sales/allQuotation'					=> array('admin','accounts','sales'),

        

        //purchase
        'purchase'								=> array('admin','sales', 'accounts'),
        'purchase/newPurchase'					=> array('admin','sales', 'accounts'),
        'purchase/purchaseList'					=> array('admin','sales', 'accounts'),
        'purchase/receivedProductList'			=> array('admin','sales', 'accounts'),

    ),


    // For debug purpose (available only when ENVIRONMENT = 'development')
    'debug' => array(
        'view_data'		=> FALSE,	// whether to display MY_Controller's mViewData at page end
        'profiler'		=> FALSE,	// whether to display CodeIgniter's profiler at page end
    ),
);