<nav class="navbar navbar-default">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">

		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
				data-target="#mainNav">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="#"><img class="img-responsive" height="100%" width="100%"
											  src="<?php echo $employee->photo !='' ? site_url(UPLOAD_EMPLOYEE.$employee->employee_id.'/'.$employee->photo) : site_url(IMAGE.'client.png') ?>"></a>
		<span class="site-name"><b><?php echo $employee->first_name ?></b> <?php echo $employee->last_name ?></span>
		<span class="site-description" ><?php echo $employee->department ?> : <?php echo $employee->job_title ?></span>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="mainNav">

		<ul class="nav main-menu navbar-nav">
			<?php foreach ($menu as $parent => $parent_params): ?>

				<?php if (empty($parent_params['children'])): ?>

					<?php $active = ($current_uri==$parent_params['url'] || $ctrler==$parent); ?>
					<li <?php if ($active) echo 'class="active"'; ?>>
						<a href='<?php echo $parent_params['url']; ?>'>
							<?php echo $parent_params['name']; ?>
						</a>
					</li>

				<?php else: ?>

					<?php $parent_active = ($ctrler==$parent); ?>
					<li class='dropdown <?php if ($parent_active) echo 'active'; ?>'>
						<a data-toggle='dropdown' class='dropdown-toggle' href='#'>
							<?php echo $parent_params['name']; ?> <span class='caret'></span>
						</a>
						<ul role='menu' class='dropdown-menu'>
							<?php foreach ($parent_params['children'] as $name => $url): ?>
								<li><a href='<?php echo $url; ?>'><?php echo $name; ?></a></li>
							<?php endforeach; ?>
						</ul>
					</li>

				<?php endif; ?>

			<?php endforeach; ?>
		</ul>

		<?php if ( !empty($rightMenu) ): ?>
			<ul class="nav navbar-nav navbar-right">
				<?php foreach ($rightMenu as $parent => $parent_params): ?>

					<?php if (empty($parent_params['children'])): ?>

						<?php $active = ($current_uri==$parent_params['url'] || $ctrler==$parent); ?>
						<li <?php if ($active) echo 'class="active"'; ?>>
							<a href='<?php echo $parent_params['url']; ?>'>
								<?php echo $parent_params['name']; ?>
							</a>
						</li>

					<?php else: ?>

						<?php $parent_active = ($ctrler==$parent); ?>
						<li class='dropdown <?php if ($parent_active) echo 'active'; ?>'>
							<a data-toggle='dropdown' class='dropdown-toggle' href='#'>
								<?php echo $parent_params['name']; ?> <span class='caret'></span>
							</a>
							<ul role='menu' class='dropdown-menu'>
								<?php foreach ($parent_params['children'] as $name => $url): ?>
									<li><a href='<?php echo $url; ?>'><?php echo $name; ?></a></li>
								<?php endforeach; ?>
							</ul>
						</li>

					<?php endif; ?>

				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div><!-- /.navbar-collapse -->
</nav>