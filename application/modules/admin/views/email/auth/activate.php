<?php $this->load->view('email/_header'); ?>
<h1><?php echo sprintf(lang('email_activate_heading'), $identity);?></h1>
<p>
Your Login email is	   : <?php echo $identity; ?><br/>
Your Login password is : <?php echo $password; ?><br/>
</p>
<p><?php echo sprintf(lang('email_activate_subheading'), anchor('auth/activate/'. $id .'/'. $activation, lang('email_activate_link')));?></p>

<?php $this->load->view('email/_footer'); ?>