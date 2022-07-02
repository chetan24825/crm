<?php $this->load->view('reminder/_header'); ?>
<h1><?php echo $customer['domain']->domain_name ?> Domain</h1>
<p>Hi, <?php echo $customer['customer']->name; ?> <strong>(<?php echo $customer['customer']->company_name ?>)</strong>
<p><?php echo $customer['msg']; ?></p>
<br/>
<p>If you have any question, please contact us via <a href="mailto:info@brutecorp.com">info@brutecorp.com</p>
<?php $this->load->view('reminder/_footer'); ?>