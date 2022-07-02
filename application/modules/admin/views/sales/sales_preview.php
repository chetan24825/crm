<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl">
                <section class="invoice">

                    <div class="print-invoice">
                        <?php 
                            $company=$this->global_model->select_field_where_db('company',array('id ='.$order->company_id),'company');
                            $words = explode(' ', $company); $cmp = $words[0][0]. $words[1][0];                    
                        ?>
                        <!-- View massage -->
                        <?php echo message_box('success'); ?>
                        <?php echo message_box('error'); ?>
                        <link href="<?php echo base_url(); ?>assets/css/AdminLTE.css" media="print" rel="stylesheet" type="text/css" />
                        <link href="<?php echo base_url(); ?>assets/css/bootstrap/css/bootstrap.css" media="print" rel="stylesheet" type="text/css" />

                        <!-- title row -->
                        <div class="row">
                            <div class="col-xs-12">
                                <h2 class="page-header">
                                    <?= get_option('company_name') ?>
                                    <small class="pull-right"><?= lang('date') ?>: <?= $order->date ?></small>
                                </h2>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-6">
                                <?= lang('billing_address') ?>
                                <address>
                                    <strong><?= $customer->name ?></strong><br>
                                    <?= $customer->city_name .", ".$customer->state_name ?>
                                    <br>
                                    <?= $order->address ?><br>
                                    <?= lang('phone') ?>: <?= "+".$customer->phone_code.$customer->phone_1 ?><br>
                                    <?= lang('email') ?>: <?= $customer->email ?><br>
                                    <?php if(!empty($order->gst)){ ?>
                                    GST Number : <?= $order->gst ?>
                                    <?php } ?>
                                </address>
                            </div>

                            <div class="col-sm-6 text-right">
                                    <?php if(!empty($order->order_no)) { ?>
                                         <h3><?= get_option('invoice_prefix') ?><?= $order->order_no ?></h3><br>
                                     <?php }else{ ?>
                                        <h3><?= get_option('invoice_prefix') ?><?= $cmp ?><?= INVOICE_PRE + $order->id ?></h3><br>
                                    <?php } ?>
                                    <br>
                                    <b><?= lang('order_date') ?>:</b> <?php echo $this->localization->dateFormat($order->invoice_date) ?><br>
                                    <b><?= lang('payment_due') ?>:</b> <?php echo $this->localization->dateFormat($order->due_date)?><br>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row" style="padding-top: 50px">
                            <div class="col-xs-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><?= lang('sl') ?>.</th>
                                            <th><?= lang('product') ?></th>
                                            <th><?= lang('description') ?></th>
                                            <th><?= lang('renewal_date') ?></th>
                                            <th><?= lang('renewal_period') ?></th>
                                            <th><?= lang('price') ?></th>
                                            <th><?= lang('qty') ?></th>
                                            <th><?= lang('subtotal') ?> (<?= get_option('currency_symbol') ?>)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($order_details as $item) { ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $item->product_name ?></td>
                                                <td><?= $item->description ?></td>
                                                <td><?= $this->localization->dateFormat($item->renewal_date)  ?></td>
                                                <td><?= ucwords($item->renewal_period) ?></td>
                                                <td><?= $item->sales_cost ?></td>
                                                <td><?= $item->qty ?></td>
                                                <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($item->sales_cost * $item->qty) ?></td>
                                            </tr>
                                        <?php $i++;
                                        } ?>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">

                            <!-- accepted payments column -->
                            <div class="col-xs-6">
                                <?php if ($order->status != 'Cancel') { ?>
                                    <?php if (!empty($order->order_note)) { ?>
                                        <p class="lead"><?= lang('order_note') ?>:</p>
                                        <p>
                                            <?= $order->order_note ?>
                                        </p>
                                <?php };
                                } ?>


                                <?php if ($order->status === 'Cancel') {
                                    if (isset($order->cancel_note)) { ?>
                                        <p class="lead"><?= lang('cancellation_note') ?>:</p>
                                        <p>
                                            <?= $order->cancel_note ?>
                                        </p>
                                <?php };
                                } ?>

                                <?php if ($type != 'Quotation') { ?>
                                    <div class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                        <?php echo get_option('invoice_text') ?>
                                    </div>
                                <?php } ?>

                                <?php foreach ($payment as $id) { ?>
                                    <?php if($id->attachment != ''){ ?>
                                    <div class="text-muted no-shadow" style="margin-top: 10px;">
                                        <img src="<?php echo $id->attachment !='' ? site_url(UPLOAD_BILL.$id->attachment ) : site_url(IMAGE.'client.png') ?>" class="img-responsive" alt="" style="width:600px; height:200px;">
                                    </div>
                                    <?php } ?>
                                <?php } ?>

                            </div>
                            <!-- /.col -->
                            <div class="col-xs-6">

                                <?php if ($type != 'Quotation') { ?>
                                    <p class="lead"><?= lang('amount_due') ?>: <?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($order->due_payment) ?></p>
                                <?php } ?>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width:50%"><?= lang('subtotal') ?>:</th>
                                                <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($order->cart_total) ?></td>
                                            </tr>
                                            <?php if($order->tax > 0){ ?>
                                            <tr>
                                                <th><?= lang('tax') ?>:</th>
                                                <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($order->tax) ?></td>
                                            </tr>
                                            <?php } ?>
                                            <?php if($order->gst_tax > 0){ ?>
                                            <?php $gst_amount = ($order->cart_total * $order->gst_tax) / 100; ?>
                                            <tr>
                                                <th>GST:</th>
                                                <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($gst_amount) ?> (<?= $order->gst_tax ?>%)</td>
                                            </tr>
                                            <?php } ?>
                                            <?php if($order->cgst_tax > 0){ ?>
                                            <?php $cgst_amount = ($order->cart_total * $order->cgst_tax) / 100; ?>
                                            <tr>
                                                <th>CGST:</th>
                                                <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($cgst_amount) ?> (<?= $order->cgst_tax ?>%)</td>
                                            </tr>
                                            <?php } ?>
                                            <?php if($order->sgst_tax > 0){ ?>
                                            <?php $sgst_amount = ($order->cart_total * $order->sgst_tax) / 100; ?>
                                            <tr>
                                                <th>SGST:</th>
                                                <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($sgst_amount) ?> (<?= $order->sgst_tax ?>%)</td>
                                            </tr>
                                            <?php } ?>
                                            <?php if($order->igst_tax > 0){ ?>
                                            <?php $igst_amount = ($order->cart_total * $order->igst_tax) / 100; ?>
                                            <tr>
                                                <th>IGST:</th>
                                                <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($igst_amount) ?> (<?= $order->igst_tax ?>%)</td>
                                            </tr>
                                            <?php } ?>
                                            <?php if($order->discount > 0) { ?>
                                                <?php $discount_amount = ($order->cart_total * $order->discount) / 100; ?>
                                                <tr>
                                                    <th><?= lang('discount') ?>:</th>
                                                    <td><?= get_option('currency_symbol') . ' - ' . $this->localization->currencyFormat($discount_amount) ?> (<?= $order->discount ?>%)</td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <th><?= lang('grand_total') ?>:</th>
                                                <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($order->grand_total) ?></td>
                                            </tr>
                                            <tr>
                                                <th><?= lang('received_amount') ?> :</th>
                                                <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($order->amount_received) ?></td>
                                            </tr>
                                            <tr>
                                                <th><?= lang('amount_due') ?> :</th>
                                                <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($order->due_payment) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                    </div>

                    <?php if (!empty($payment)) { ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="info">
                                    <th><?= lang('date') ?></th>
                                    <th><?= lang('payment_ref') ?>.</th>
                                    <th><?= lang('payment_method') ?></th>
                                    <th><?= lang('amount') ?></th>
                                    <th><?= lang('received_by') ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($payment as $id) { ?>
                                    <tr>
                                        <td><?php dateFormat($id->payment_date) ?></td>
                                        <td><?php echo $id->payment_ref ?></td>
                                        <td><?php echo $id->payment_method ?></td>
                                        <td><?php echo currency($id->amount) ?></td>
                                        <td><?php echo $id->received_by ?></td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    <?php } ?>

                    <div class="row no-print">
                        <div class="col-xs-12">

                            <a id="printButton" class="btn btn-outline btn-primary"><i class="fa fa-print"></i> <?= lang('print') ?></a>

                            <a onclick="return confirm('Are you sure want to delete this Invoice ?');" href="<?php echo base_url() ?>admin/sales/deleteInvoice/<?php echo get_orderID($order->id) ?> " class="btn btn-danger pull-right" style="margin-right: 5px;">
                                <i class="fa fa-trash"></i> <?= lang('delete') ?>
                            </a>


                            <!--<a href="<?php echo base_url() ?>admin/sales/cancelSales/<?php echo get_orderID($order->id) ?> " data-target="#modalSmall" data-toggle="modal" class="btn btn-warning pull-right" style="margin-right: 5px;">-->
                            <!--    <i class="fa fa-close"></i> <?= lang('cancel') ?>-->
                            <!--</a>-->

                            <a href="<?php echo base_url() ?>admin/sales/paymentList/<?php echo get_orderID($order->id) ?> " data-target="#myModal" data-toggle="modal" class="btn bg-olive pull-right" style="margin-right: 5px;">
                                <i class="fa fa-money"></i> <?= lang('view_payment') ?>
                            </a>

                            <a href="<?php echo base_url() ?>admin/sales/addPayment/<?php echo get_orderID($order->id) ?> " data-target="#modalSmall" data-toggle="modal" class="btn bg-purple pull-right" style="margin-right: 5px;">
                                <i class="fa fa-money"></i> <?= lang('add_payment') ?>
                            </a>

                            <a href="<?php echo base_url() ?>admin/sales/createPdfInvoice/<?php echo get_orderID($order->id) ?> " class="btn btn-info pull-right" style="margin-right: 5px;">
                                <i class="fa fa-download"></i> <?= lang('generate_pdf') ?>
                            </a>

                            <a href="<?php echo base_url() ?>admin/sales/sendInvoice/<?php echo get_orderID($order->id) ?> " data-target="#modalSmall" data-toggle="modal" class="btn btn-primary pull-right" style="margin-right: 5px;">
                                <i class="fa fa-envelope"></i> <?= lang('email') ?>
                            </a>

                            <a href="<?php echo base_url() ?>admin/sales/updateSales/<?php echo get_orderID($order->id) ?> " class="btn btn-success pull-right" style="margin-right: 5px;">
                                <i class="fa fa-edit"></i> <?= lang('edit') ?>
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        </div>  
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#printButton").click(function() {
            var mode = 'iframe'; // popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.print-invoice").printArea(options);
        });
    });
</script>