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



$CI = & get_instance();
$CI->load->database();
$lang = 0;

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
	'name' => '',

	// Default page title
	// (set empty then MY_Controller will automatically generate one based on controller / action)
	'title' => '',

	// Default meta data (name => content)
	'meta'	=> array(
		'author'		=> 'Codes Lab, www.codeslab.net',
		'description'	=> 'Codes Lab is a perfect combination of developers and designers who understand clients need and desire and deliver more than which has been promised. We consider your satisfaction as the most powerful return on our efforts.'
	),

	// Default scripts to embed at page head / end
		'scripts' => array(
				'foot'	=> array(
					'assets/js/jquery-3.1.1.min.js',
					'assets/js/popper.min.js',
					'assets/js/bootstrap.js',
					'assets/js/plugins/metisMenu/jquery.metisMenu.js',
					'assets/js/plugins/slimscroll/jquery.slimscroll.min.js',
					'assets/js/plugins/flot/jquery.flot.js',
					'assets/js/plugins/flot/jquery.flot.tooltip.min.js',
					'assets/js/plugins/flot/jquery.flot.spline.js',
					'assets/js/plugins/flot/jquery.flot.resize.js',
					'assets/js/plugins/flot/jquery.flot.pie.js',
					'assets/js/plugins/flot/jquery.flot.symbol.js',
					'assets/js/plugins/flot/curvedLines.js',
					'assets/js/plugins/peity/jquery.peity.min.js',
					'assets/js/demo/peity-demo.js',
					'assets/js/inspinia.js',
					'assets/js/plugins/pace/pace.min.js',
					'assets/js/plugins/jquery-ui/jquery-ui.min.js',
					'assets/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js',
					'assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
					'assets/js/plugins/sparkline/jquery.sparkline.min.js',
					'assets/js/demo/sparkline-demo.js',
					
				),
		),


		'stylesheets' => array(
				'screen' => array(

					'assets/css/bootstrap/css/bootstrap.css',
					'assets/plugin/select2/select2.min.css',
					'assets/css/AdminLTE.css',
						'assets/css/custom.css',
						'assets/frontend.css',
//						'assets/css/skins.css',
					//data tables
					'assets/plugin/datatables/jquery.dataTables.min.css',
					'assets/plugin/datatables/buttons.bootstrap.min.css',
					'assets/plugin/datatables/fixedHeader.bootstrap.min.css',
					'assets/plugin/datatables/responsive.bootstrap.min.css',
					'assets/plugin/datatables/scroller.bootstrap.min.css',

					'assets/plugin/daterangepicker/daterangepicker-bs3.css',
					'assets/plugin/datepicker/datepicker3.css',
					'assets/plugin/colorpicker/bootstrap-colorpicker.min.css',
					'assets/plugin/timepicker/bootstrap-timepicker.min.css',

					'assets/plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
					//'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
					//'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
					'assets/css/font-awesome.min',
					'assets/css/ionicons.min',

					//graphChart
					'assets/plugin/morris/morris.css',

					//calendar
					'assets/plugin/fullcalendar/fullcalendar.min.css',
					//'assets/plugin/fullcalendar/fullcalendar.print.css',
				)
		),



	// Multilingual settings (set empty array to disable this)
		'rightMenu' => array(

			'logout' => array(
					'name'		=> 'Logout',
					'url'		=> 'auth/logout',
					'icon'		=> 'fa fa-tachometer',
			),
		),


	// Multilingual settings (set empty array to disable this)
//	'multilingual' => array(
//		'default'		=> 'en',			// to decide which of the "available" languages should be used
//		'available'		=> array(			// availabe languages with names to display on site (e.g. on menu)
//			'en' => array(					// abbr. value to be used on URL, or linked with database fields
//				'label'	=> 'English',		// label to be displayed on language switcher
//				'value'	=> 'english',		// to match with CodeIgniter folders inside application/language/
//			),
//			'zh' => array(
//				'label'	=> '繁體中文',
//				'value'	=> 'traditional-chinese',
//			),
//			'cn' => array(
//				'label'	=> '简体中文',
//				'value'	=> 'simplified-chinese',
//			),
//		),
//		//'autoload'		=> array('general'),	// language files to autoload
//	),

	// Google Analytics User ID (UA-XXXXXXXX-X)
	'ga_id' => '',
	
	// Menu items
	// (or directly update view file: applications/views/_partials/navbar.php)
	'menu' => array(

		'home' => array(
			'name'		=> $CI->lang->line('home'),
			'url'		=> 'client/home/',
		),

		'profile' => array(
				'name'		=> $CI->lang->line('profile'),
				'url'		=> 'client/profile/',
		),

		'mail' => array(
				'name'		=> $CI->lang->line('mail'),
				'url'		=> 'mail',
				'children'  => array(
						$CI->lang->line('inbox')					=> 'client/mail',
						$CI->lang->line('sent_item')				=> 'client/mail/sentItem',

				)
		),


		'notice' => array(
				'name'		=> $CI->lang->line('notice'),
				'url'		=> 'client/home/allNotice',
		),

	),

	// default page when redirect non-logged-in user
	'login_url' => 'auth/login',

	// restricted pages to specific groups of users, which will affect sidemenu item as well
	// pages out of this array will have no restriction
	'page_auth' => array(
		'account'		=> array('members')
	),

	// For debug purpose (available only when ENVIRONMENT = 'development')
	'debug' => array(
		'view_data'		=> FALSE,	// whether to display MY_Controller's mViewData at page end
		'profiler'		=> FALSE,	// whether to display CodeIgniter's profiler at page end
	),
);