<?php $this->load->view('reminder/_header'); ?>
<h1><?php echo $customer['hosting']->hosting_company ?> Hosting</h1>
<p>Hi, <?php echo $customer['customer']->name; ?> <strong>(<?php echo $customer['customer']->company_name ?>)</strong>
<p>Your <?php echo $customer['hosting']->hosting_company ?> Hosting will be expired on <?php echo $customer['day'] ?></p>
<br/>
<p>If you have any question, please contact us via <a href="mailto:info@brutecorp.com">info@brutecorp.com</p>
<?php $this->load->view('reminder/_footer'); ?>