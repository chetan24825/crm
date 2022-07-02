<?php if ($this->ion_auth->in_group(array('admin', 'accounts'))) { ?>
	<div class="wrapper wrapper-content">		
		<div class="row">
			<div class="col-lg-8">
			    <?php echo message_box('success'); ?>
			    <?php echo message_box('error'); ?>
				<div class="ibox ">
					<div class="ibox-title">
						<h5><?= lang('recent_order') ?></h5>
					</div>
					<div class="ibox-content">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th><?= lang('order_id') ?></th>
										<th><?= lang('customer') ?></th>
										<th><?= lang('date') ?></th>
										<th><?= lang('order_total') ?></th>
									</tr>
								</thead>
								<tbody>
									<?php if ($order_info) : foreach ($order_info as $v_order) : ?>
											<tr>
												<td><a href="<?php echo base_url() ?>admin/sales/sale_preview/<?php echo get_orderID($v_order->id) ?>"><?php echo get_orderID($v_order->id) ?></a></td>
												<td><?php echo $v_order->customer_name ?></td>
												<td><?php echo dateFormat($v_order->date) ?></td>

												<td class="highlight"><strong><?php echo currency($v_order->grand_total)  ?></strong></td>
											</tr>
										<?php endforeach;
									else : ?>
										<tr style="column-span: 5">
											<td><strong><?= lang('no_records_found') ?></strong></td>
										</tr>

									<?php endif ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="ibox ">
					<div class="ibox-title">
						<h5><?= lang('top_5_selling_product') ?> </h5>
						<span class="label label-warning float-right"><?php echo date('F') ?></span>
					</div>
					<div class="ibox-content">
						<table class="table no-margin">
							<thead>
								<tr>
									<th><?= lang('sl') ?></th>
									<th><?= lang('product') ?></th>
									<th><?= lang('qty') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($top_sell_product_month)) :
									$top_product = array_slice($top_sell_product_month, 0, 5);
									$i = 1;
								?>
									<?php foreach ($top_product as $item) : ?>
										<tr>
											<td><?php echo $i ?></td>
											<td class="highlight"><?php echo $item->product_name ?></td>
											<td class="highlight"><strong><?php echo $item->quantity ?></strong></td>
											<?php $i++ ?>
										</tr>
									<?php endforeach;
								else : ?>
									<tr style="column-span: 4">
										<td><strong><?= lang('no_records_found') ?></strong></td>
									</tr>

								<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>