<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		// CI Bootstrap libraries
		$this->load->library('form_builder');
		$this->load->library('system_message');
		$this->load->library('email_client');

		$this->push_breadcrumb('Auth');
	}

	/**
	 * Registration page
	 */
//	public function sign_up()
//	{
//		$form = $this->form_builder->create_form();
//
//		if ($form->validate())
//		{
//			// passed validation
//			$identity = $this->input->post('email');
//			$password = $this->input->post('password');
//			$additional_data = array(
//				'first_name'	=> $this->input->post('first_name'),
//				'last_name'		=> $this->input->post('last_name'),
//			);
//
//			// create user (default group as "members")
//			$user = $this->ion_auth->register($identity, $password, $identity, $additional_data);
//			if ($user)
//			{
//				// send email using Email Client library
//				if ($this->config->item('email_activation', 'ion_auth') && !$this->config->item('use_ci_email', 'ion_auth'))
//				{
//					$subject = $this->lang->line('email_activation_subject');
//					$email_view = $this->config->item('email_templates', 'ion_auth').$this->config->item('email_activate', 'ion_auth');
//					$this->email_client->send($identity, $subject, $email_view, $user);
//				}
//
//				// success
//				$messages = $this->ion_auth->messages();
//				$this->system_message->set_success($messages);
//				redirect('auth/login');
//			}
//			else
//			{
//				// failed
//				$errors = $this->ion_auth->errors();
//				$this->system_message->set_error($errors);
//				refresh();
//			}
//		}
//
//		// require reCAPTCHA script at page head
//		$this->mScripts['head'][] = 'https://www.google.com/recaptcha/api.js';
//
//		// display form
//		$this->mViewData['form'] = $form;
//		$this->render('auth/sign_up');
//	}

	/**
	 * Login page
	 */
	public function login()
	{
		$form = $this->form_builder->create_form();

		if ($form->validate())
		{
			// passed validation
			$identity = $this->input->post('email');
			$password = $this->input->post('password');
			$remember = ($this->input->post('remember')=='on');

			$this->ion_auth_model->identity_column = 'email';
			
			if ($this->ion_auth->login($identity, $password, $remember))
			{
				// success
				$messages = $this->ion_auth->messages();
				$this->system_message->set_success($messages);

				// redirect to user dashboard
				redirect('client/home');
			}
			else
			{
				// failed
				$errors = $this->ion_auth->errors();
				$this->system_message->set_error($errors);
				refresh();
			}
		}

		// display form
		//$this->mViewData['form'] = $form;
		$data['form'] = $form;
		$this->load->view('auth/login', $data);
		//$this->render('auth/login');
	}

	/**
	 * Logout
	 */
	public function logout()
	{
		$this->ion_auth->logout();	
		redirect();
	}

	/**
	 * Activation
	 */
	public function activate($id = NULL, $code = NULL)
	{
		if ( empty($id) )
		{
			redirect();
		}
		else if ( !empty($code) )
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			// success
			$messages = $this->ion_auth->messages();
			$this->system_message->set_success($messages);
			redirect('auth/login');
		}
		else
		{
			// failed
			$errors = $this->ion_auth->errors();
			$this->system_message->set_error($errors);
			redirect('auth/forgot_password');
		}
	}

	/**
	 * Forgot Password page
	 */
//	public function forgot_password()
//	{
//		$form = $this->form_builder->create_form();
//
//		if ($form->validate())
//		{
//			// passed validation
//			$identity = $this->input->post('email');
//			$user = $this->ion_auth->forgotten_password($identity);
//
//			if ($user)
//			{
//				if (!$this->config->item('use_ci_email', 'ion_auth'))
//				{
//					// send email using Email Client library
//					$subject = $this->lang->line('email_forgotten_password_subject');
//					$email_view = $this->config->item('email_templates', 'ion_auth').$this->config->item('email_forgot_password', 'ion_auth');
//					$this->email_client->send($identity, $subject, $email_view, $user);
//				}
//
//				// success
//				$messages = $this->ion_auth->messages();
//				$this->system_message->set_success($messages);
//				redirect('auth/login');
//			}
//			else
//			{
//				// failed
//				$errors = $this->ion_auth->errors();
//				$this->system_message->set_error($errors);
//				refresh();
//			}
//		}
//
//		// display form
//		$this->mViewData['form'] = $form;
//		$this->render('auth/forgot_password');
//	}

	/**
	 * Reset Password page
	 */
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			redirect();
		}

		// check whether code is valid
		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			$form = $this->form_builder->create_form();

			if ($form->validate())
			{
				// passed validation
				$identity = $user->email;
				$password = $this->input->post('password');
				
				// confirm update password
				if ( $this->ion_auth->reset_password($identity, $password) )
				{
					if (!$this->config->item('use_ci_email', 'ion_auth'))
					{
						// send email using Email Client library
						$subject = $this->lang->line('email_new_password_subject');
						$email_view = $this->config->item('email_templates', 'ion_auth').$this->config->item('email_forgot_password_complete', 'ion_auth');
						$data = array('identity' => $identity);
						$this->email_client->send($identity, $subject, $email_view, $data);
					}

					// success
					$messages = $this->ion_auth->messages();
					$this->system_message->set_success($messages);
					redirect('auth/login');
				}
				else
				{
					// failed
					$errors = $this->ion_auth->errors();
					$this->system_message->set_error($errors);
					redirect('auth/reset_password/' . $code);
				}
			}

			// display form
			$this->mViewData['form'] = $form;
			$this->render('auth/reset_password');
		}
		else
		{
			// code invalid
			$errors = $this->ion_auth->errors();
			$this->system_message->set_error($errors);
			redirect('auth/forgot_password', 'refresh');
		}
	}
	
// 	function customer_domain(){
// 		$notification = get_option('email_notification');
// 		if($notification =='yes'){
// 			$domains = $this->db->get_where('customer_domain', array('active' => 1))->result();
// 			if($domains){
// 			    foreach($domains as $domain){
// 				$now = time(); // or your date as well
// 				$your_date = strtotime($domain->renewal_date);
				
// 				$datediff = ceil(($your_date-$now)/86400);
// 				$customer = $this->db->select('name,email,company_name')->get_where('customer', array('id' => $domain->customer_id))->row();
// 				$to_list = $customer->email; 
// 				if ($now > $your_date) {
// 					$update = array(
// 					'active' => 0,
// 					'reading' => 0
// 					);
// 					$this->db->update('customer_domain',$update,'id='.$domain->id);
// 					$this->db->set('reading', 0, FALSE)->where('id', $domain->id)->update('customer_domain'); 
// 					$data['customer'] = $customer;
// 					$data['domain'] = $domain;
// 					$date = date('Y-m-d', $now);
// 					$expiryDate = date('l, d M,Y', $your_date); 
// 					$data['msg'] = 'Your '.$domain->domain_name.' Domain is expired on '.$expiryDate;             
// 					$this->sendDomainEmail($to_list,$data);
// 				}else{
// 					if((int)$datediff == 24){ //on 24 Day Reminder                
// 						$this->db->set('reading', 0, FALSE)->where('id', $domain->id)->update('customer_domain'); 
// 						$data['customer'] = $customer;
// 						$data['domain'] = $domain;
// 						$date = date('Y-m-d', $now);
// 						$renewalDay = date('l, d M,Y', strtotime($date. ' + '.$datediff.' days'));
// 						$data['msg'] = 'Your '.$domain->domain_name.' Domain will be expired on '.$renewalDay;              
// 						$this->sendDomainEmail($to_list,$data);
// 					}elseif((int)$datediff == 12){ //12 Days Reminder
// 						$this->db->set('reading', 0, FALSE)->where('id', $domain->id)->update('customer_domain');
// 						$data['customer'] = $customer;
// 						$data['domain'] = $domain; 
// 						$date = date('Y-m-d', $now);
// 						$renewalDay = date('l, d M,Y', strtotime($date. ' + '.$datediff.' days'));
// 						$data['msg'] = 'Your '.$domain->domain_name.' Domain will be expired on '.$renewalDay;              
// 						$this->sendDomainEmail($to_list,$data);
// 					}elseif((int)$datediff <= 5){
// 						$date = date('Y-m-d', $now);
// 						$renewalDay = date('Y-m-d', strtotime($date. ' + '.$datediff.' days'));
// 						$expiryDay = date('l', strtotime($renewalDay));
// 						$this->db->set('reading', 0, FALSE)->where('id', $domain->id)->update('customer_domain'); 			
// 						$data['customer'] = $customer;
// 						$data['domain'] = $domain;
// 						if($datediff == 1){
// 							$expiryDay = 'tomorrow';
// 						}
// 						$data['msg'] = 'Your '.$domain->domain_name.' Domain will be expired on '.$expiryDay;      
// 						$this->sendDomainEmail($to_list,$data);
// 					}
// 				}
// 			}
// 			}
// 		}
// 	}
// 	function customer_hosting(){
// 		$notification = get_option('email_notification');
// 		if($notification =='yes'){
// 			$hostings = $this->db->get_where('customer_hosting', array('active' => 1))->result();
// 			if($hostings){
// 			    foreach($hostings as $hosting){
// 				$now = time(); // or your date as well
// 				$your_date = strtotime($hosting->renewal_date);
// 				$datediff = ceil(($your_date-$now)/86400);	
// 				$customer = $this->db->select('name,email,company_name')->get_where('customer', array('id' => $hosting->customer_id))->row();
// 				$to_list = $customer->email;
// 				$data['customer'] = $customer;
// 				$data['hosting'] = $hosting;
// 				if ($now > $your_date) {
// 					$update = array(
// 					'active' => 0,
// 					'reading' => 0
// 					);
// 					$this->db->update('customer_hosting',$update,'id='.$hosting->id);
// 					$date = date('Y-m-d', $now);
// 					$expiryDate = date('l, d M,Y', $your_date); 
// 					$data['msg'] = 'Your '.$hosting->hosting_name.' Hosting is expired on '.$expiryDate;             
// 					$this->sendEmail($to_list,$data);
// 				}else{
// 					if((int)$datediff == 24){ //on 24 Day Reminder
// 						$this->db->set('reading', 0, FALSE)->where('id', $domain->id)->update('customer_domain'); 
// 						$date = date('Y-m-d', $now);
// 						$renewalDay = date('l, d M,Y', strtotime($date. ' + '.$datediff.' days'));
// 						$data['msg'] = 'Your '.$hosting->hosting_name.' Hosting will be expired on '.$renewalDay;              
// 						$this->sendEmail($to_list,$data);
						
// 					}elseif((int)$datediff == 12){ //12 Days Reminder
// 						$this->db->set('reading', 0, FALSE)->where('id', $hosting->id)->update('customer_hosting');
// 						$date = date('Y-m-d', $now);
// 						$renewalDay = date('l, d M,Y', strtotime($date. ' + '.$datediff.' days'));
// 						$data['msg'] = 'Your '.$hosting->hosting_name.' Domain will be expired on '.$renewalDay;   
// 						$this->sendEmail($to_list,$data);
// 					}elseif((int)$datediff <= 5){
// 						$date = date('Y-m-d', $now);
// 						$renewalDay = date('Y-m-d', strtotime($date. ' + '.$datediff.' days'));
// 						$expiryDay = date('l', strtotime($renewalDay));
// 						$this->db->set('reading', 0, FALSE)->where('id', $hosting->id)->update('customer_hosting');	
// 						if($datediff == 1){
// 							$expiryDay = 'tomorrow';
// 						}
// 						$data['day'] = $expiryDay;
// 						$data['msg'] = 'Your '.$hosting->hosting_name.' Hosting will be expired on '.$expiryDay;      
// 						$this->sendEmail($to_list,$data);
// 					}
// 				}
// 			}
// 			}
// 		}
//     }

	function sendEmail($email='',$customer){
        $config = Array(
            'protocol' => "smtp",
            'smtp_host' => get_option('smtp_host'),
            'smtp_port' => get_option('smtp_port'),
            'smtp_user' => get_option('smtp_username'),
            'smtp_pass' => get_option('smtp_password'),
            'mailtype'  => "html",
            'charset'   => "iso-8859-1"
        );
        
        $this->load->library('email', $config);
        $this->email->from('info@crm.brutecorp.com', get_option('mail_sender'));
        $this->email->to($email);
        $data['customer'] = $customer;
        $msg = $this->load->view('reminder/reminder/hosting',$data, TRUE);
        $this->email->subject('Hosting Expiry Reminder');
        $this->email->message($msg);
        $this->email->send();
    }

	function sendDomainEmail($email='',$customer){
        $config = Array(
                'protocol' => "smtp",
                'smtp_host' => get_option('smtp_host'),
                'smtp_port' => get_option('smtp_port'),
                'smtp_user' => get_option('smtp_username'),
                'smtp_pass' => get_option('smtp_password'),
                'mailtype'  => "html",
                'charset'   => "iso-8859-1"
            );
        
        $this->load->library('email', $config);
        $this->email->from('info@crm.brutecorp.com', get_option('mail_sender'));
        $this->email->to($email);
        $data['customer'] = $customer;
        $msg = $this->load->view('reminder/reminder/domain',$data, TRUE);
		$this->email->subject('Domain Expiry Reminder');
        $this->email->message($msg);
        if ($this->email->send()) {
            echo 'Your Email has successfully been sent.';
        } else {
            show_error($this->email->print_debugger());
        }
    }
}
