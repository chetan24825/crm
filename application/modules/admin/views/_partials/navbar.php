<?php
$id = $this->ion_auth->user()->row()->id;
$hosting = $this->db->get_where('customer_hosting', array(
	'reading' => 0,
))->result();
$totalHosting = count($hosting);

$domain = $this->db->get_where('customer_domain', array(
	'reading' => 0,
))->result();
$totalDomain = count($domain);

$totalMessage = $totalHosting + $totalDomain;
?>

<div class="row border-bottom">
	<nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
		<div class="navbar-header">
			<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
			<form role="search" class="navbar-form-custom" action="search_results.html">
				<div class="form-group">
					<input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
				</div>
			</form>
		</div>
		<ul class="nav navbar-top-links navbar-right">
			<li class="dropdown messages-menu">
				<!-- Menu toggle button -->
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<div class="notification-badge notification-badge--has-new">
						<span class="notification-badge__counter"><?php echo $totalMessage ?></span> <svg>
							<use xlink:href="<?php echo base_url('assets/css/svg-shared-sprite.a16a70b04feb.svg') ?>#sprite-bell"></use>
						</svg>
					</div>
				</a>
				<ul class="dropdown-menu notification-list">
					<?php if ($totalMessage) {
						if (!empty($domain)) {
							foreach ($domain as $item) {
								$now = time(); // or your date as well
								$your_date = strtotime($item->renewal_date);
								$expiryDate = date('l, d M,Y', $your_date);
								$datediff = ceil(($your_date - $now) / 86400);
								$date = date('Y-m-d', $now);
								$msg = '';
								if ($now > $your_date) {
									$msg = $domain->domain_name . ' Domain is expired on ' . $expiryDate;
								} elseif ((int)$datediff == 24) {
									$renewalDay = date('l, d M,Y', strtotime($date . ' + ' . $datediff . ' days'));
									$msg = $domain->domain_name . ' Domain will be expired on ' . $renewalDay;
								} elseif ((int)$datediff == 12) {
									$renewalDay = date('l, d M,Y', strtotime($date . ' + ' . $datediff . ' days'));
									$msg = $domain->domain_name . ' Domain will be expired on ' . $renewalDay;
								} elseif ((int)$datediff <= 5) {
									$renewalDay = date('Y-m-d', strtotime($date . ' + ' . $datediff . ' days'));
									$expiryDay = date('l', strtotime($renewalDay));
									if ($datediff == 1) {
										$expiryDay = 'tomorrow';
									}
									$msg = $domain->domain_name . ' Domain will be expired on ' . $expiryDay;
								}
								$customer = $this->db->select('email,company_name')->get_where('customer', array('id' => $item->customer_id))->row();					?>
								<li class="notification">
									<div class="notification__inner d-flex align-items-center">
										<div class="notification__icon"><svg class="fill-info">
												<use xlink:href="<?php echo base_url('assets/css/svg-shared-sprite.a16a70b04feb.svg') ?>#sprite-n-text"></use>
											</svg></div>
										<div class="notification__info">
											<h4 class="notification__title mb-0"><?php echo substr(strip_tags($item->domain_name), 0, 40) ?></h4>
											<p class="notification__desc mt-1 mb-0" style="white-space: pre-line;"><?php echo $msg; ?></p>
											<a href="<?php echo base_url('admin/mail/domainEmail') . '/' . str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)) ?>" class="btn btn-link p-0 m-0 mt-1 font-weight-semibold">
												Open
											</a>
										</div>
									</div>
								</li>
							<?php } ?>
						<?php } ?>
						<?php if (!empty($hosting)) { ?>
							<?php foreach ($hosting as $item) {
								$customer = $this->db->select('email,company_name')->get_where('customer', array('id' => $item->customer_id))->row();
								if ($now > $your_date) {
									$msg = $hosting->hosting_company . ' Hosting is expired on ' . $expiryDate;
								} elseif ((int)$datediff == 24) {
									$renewalDay = date('l, d M,Y', strtotime($date . ' + ' . $datediff . ' days'));
									$msg = $hosting->hosting_company . ' Hosting will be expired on ' . $renewalDay;
								} elseif ((int)$datediff == 12) {
									$renewalDay = date('l, d M,Y', strtotime($date . ' + ' . $datediff . ' days'));
									$msg = $hosting->hosting_company . ' Hosting will be expired on ' . $renewalDay;
								} elseif ((int)$datediff <= 5) {
									$renewalDay = date('Y-m-d', strtotime($date . ' + ' . $datediff . ' days'));
									$expiryDay = date('l', strtotime($renewalDay));
									if ($datediff == 1) {
										$expiryDay = 'tomorrow';
									}
									$msg = $hosting->hosting_company . ' Hosting will be expired on ' . $expiryDay;
								}
							?>
								<li class="notification">
									<div class="notification__inner d-flex align-items-center">
										<div class="notification__icon"><svg class="fill-info">
												<use xlink:href="<?php echo base_url('assets/css/svg-shared-sprite.a16a70b04feb.svg') ?>#sprite-n-text"></use>
											</svg></div>
										<div class="notification__info">
											<h4 class="notification__title mb-0"><?php echo substr(strip_tags($item->hosting_company), 0, 40) ?></h4>
											<p class="notification__desc mt-1 mb-0" style="white-space: pre-line;"><?php echo $msg; ?></p>
											<a href="<?php echo base_url('admin/mail/hostingEmail') . '/' . str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)) ?>" class="btn btn-link p-0 m-0 mt-1 font-weight-semibold">
												Open
											</a>
										</div>
									</div>
								</li>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				</ul>
			</li>
			<li>
				<a href="panel/logout">
					<i class="fa fa-sign-out"></i> Log out
				</a>
			</li>
		</ul>

	</nav>
</div>