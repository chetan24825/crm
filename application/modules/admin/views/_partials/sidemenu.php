<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav metismenu" id="side-menu">
			<li class="nav-header">
				<div class="dropdown profile-element">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<span class="block m-t-xs font-bold"><?= get_option('brand') ?></span>
						<span class="text-muted text-xs block">Art Director <b class="caret"></b></span>
					</a>
					<ul class="dropdown-menu animated fadeInRight m-t-xs">
						<li><a class="dropdown-item" href="profile.html">Profile</a></li>
						<li><a class="dropdown-item" href="contacts.html">Contacts</a></li>
						<li><a class="dropdown-item" href="mailbox.html">Mailbox</a></li>
						<li class="dropdown-divider"></li>
						<li><a class="dropdown-item" href="panel/logout">Logout</a></li>
					</ul>
				</div>
				<div class="logo-element">
					IN+
				</div>
			</li>
			<?php foreach ($menu as $parent => $parent_params) : ?>
				<?php if (empty($page_auth[$parent_params['url']]) || $this->ion_auth->in_group($page_auth[$parent_params['url']])) : ?>
					<?php if (empty($parent_params['children'])) : ?>
						<?php $active = ($current_uri == $parent_params['url'] || $ctrler == $parent); ?>
						<li class='<?php if ($active) echo 'active'; ?>'>
							<a href='<?php echo $parent_params['url']; ?>'>								
								<span class="nav-label"><?php echo $parent_params['name']; ?> </span>
							</a>
						</li>
					<?php else : ?>
						<?php $parent_active = ($ctrler == $parent); ?>
						<li class='<?php if ($parent_active) echo 'active'; ?>'>
							<a href='#'>								
								<span class="nav-label"> <?php echo $parent_params['name']; ?> </span> <i class='fa fa-angle-left pull-right'></i>
							</a>
							<ul class='nav nav-second-level collapse'>
								<?php foreach ($parent_params['children'] as $name => $url) : ?>
									<?php if (empty($page_auth[$url]) || $this->ion_auth->in_group($page_auth[$url])) : ?>
										<?php $child_active = ($current_uri == $url); ?>
										<li <?php if ($child_active) echo 'class="active"'; ?>>
											<a href='<?php echo $url; ?>'><?php echo $name; ?></a>
										</li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						</li>
					<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</div>
</nav>