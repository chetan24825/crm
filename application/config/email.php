<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| Email Settings
| -------------------------------------------------------------------
| Configuration of outgoing mail server.
| */

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'mail.brutecorp.com';
$config['smtp_port'] = '587';
$config['smtp_timeout'] = '30';
$config['smtp_user'] = 'noreply@brutecorp.com';
$config['smtp_pass'] = 'ahVIe=y_O))x';
$config['charset'] = 'utf-8';
$config['mailtype'] = 'html';
$config['wordwrap'] = TRUE;
$config['newline'] = "\r\n";

// custom values from CI Bootstrap
$config['from_email'] = "noreply@brutecorp.com";
$config['from_name'] = "CI Bootstrap";
$config['subject_prefix'] = "[CI Bootstrap] ";

// Mailgun API (to be used in Email Client library)
$config['mailgun'] = array(
	'domain'				=> '',
	'private_api_key'		=> '',
);