<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl">
                <section class="invoice">

                    <div class="print-invoice">
                        <?php 
                            //$company=$this->global_model->select_field_where_db('company',array('id ='.$estimate->company_id),'company');
                            //$words = explode(' ', $company); $cmp = $words[0][0]. $words[1][0];                    
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
                                </h2>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-6">
                                <strong>Estimate To</strong>
                                <address>
                                    <strong><?= $customer->name ?></strong><br>
                                    <?= $customer->city_name .", ".$customer->state_name ?>
                                    <br>
                                    <?= $estimate->address ?><br>
                                    <?= lang('phone') ?>: <?= "+".$customer->phone_code.$customer->phone_1 ?><br>
                                    <?= lang('email') ?>: <?= $customer->email ?><br>
                                    <?php if(!empty($estimate->gst)){ ?>
                                    GST Number : <?= $estimate->gst ?>
                                    <?php } ?>
                                </address>
                            </div>

                            <div class="col-sm-6 text-right">
                                <h3>Estimate #<?= $cmp ?><?= ESTIMATE_PRE + $estimate->id ?></h3>
                                <b>Estimate Date:</b> <?php echo $this->localization->dateFormat($estimate->estimate_date) ?><br>
                                <b>Expiration Date:</b> <?php echo $this->localization->dateFormat($estimate->valid_until)?><br>
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
                                        foreach ($estimate_details as $item) { ?>
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
                                <?php if ($estimate->status != 'Cancel') { ?>
                                    <?php if (!empty($estimate->order_note)) { ?>
                                        <p class="lead"><?= lang('order_note') ?>:</p>
                                        <p>
                                            <?= $estimate->order_note ?>
                                        </p>
                                <?php };
                                } ?>
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width:50%"><?= lang('subtotal') ?>:</th>
                                                <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($estimate->cart_total) ?></td>
                                            </tr>
                                            <?php if($estimate->tax > 0){ ?>
                                            <tr>
                                                <th><?= lang('tax') ?>:</th>
                                                <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($estimate->tax) ?></td>
                                            </tr>
                                            <?php } ?>
                                            <?php if($estimate->gst_tax > 0){ ?>
                                            <?php $gst_amount = ($estimate->cart_total * $estimate->gst_tax) / 100; ?>
                                            <tr>
                                                <th>GST:</th>
                                                <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($gst_amount) ?> (<?= $estimate->gst_tax ?>%)</td>
                                            </tr>
                                            <?php } ?>
                                            <?php if($estimate->cgst_tax > 0){ ?>
                                            <?php $cgst_amount = ($estimate->cart_total * $estimate->cgst_tax) / 100; ?>
                                            <tr>
                                                <th>CGST:</th>
                                                <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($cgst_amount) ?> (<?= $estimate->cgst_tax ?>%)</td>
                                            </tr>
                                            <?php } ?>
                                            <?php if($estimate->sgst_tax > 0){ ?>
                                            <?php $sgst_amount = ($estimate->cart_total * $estimate->sgst_tax) / 100; ?>
                                            <tr>
                                                <th>SGST:</th>
                                                <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($sgst_amount) ?> (<?= $estimate->sgst_tax ?>%)</td>
                                            </tr>
                                            <?php } ?>
                                            <?php if($estimate->igst_tax > 0){ ?>
                                            <?php $igst_amount = ($estimate->cart_total * $estimate->igst_tax) / 100; ?>
                                            <tr>
                                                <th>IGST:</th>
                                                <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($igst_amount) ?> (<?= $estimate->igst_tax ?>%)</td>
                                            </tr>
                                            <?php } ?>
                                            <?php if($estimate->discount > 0) { ?>
                                                <?php $discount_amount = ($estimate->cart_total * $estimate->discount) / 100; ?>
                                                <tr>
                                                    <th><?= lang('discount') ?>:</th>
                                                    <td><?= get_option('currency_symbol') . ' - ' . $this->localization->currencyFormat($discount_amount) ?> (<?= $estimate->discount ?>%)</td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <th><?= lang('grand_total') ?>:</th>
                                                <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($estimate->grand_total) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                    </div>

                    <div class="row no-print">
                        <div class="col-xs-12">

                            <a id="printButton" class="btn btn-outline btn-primary"><i class="fa fa-print"></i> <?= lang('print') ?></a>

                            <a onclick="return confirm('Are you sure want to delete this Invoice ?');" href="<?php echo base_url() ?>admin/sales/deleteInvoice/<?php echo get_orderID($estimate->id) ?> " class="btn btn-danger pull-right" style="margin-right: 5px;">
                                <i class="fa fa-trash"></i> <?= lang('delete') ?>
                            </a>
                            <a href="<?php echo base_url() ?>admin/estimates/createPdfInvoice/<?php echo $estimate->id ?> " class="btn btn-info pull-right" style="margin-right: 5px;">
                                <i class="fa fa-download"></i> <?= lang('generate_pdf') ?>
                            </a>

                            <a href="<?php echo base_url() ?>admin/estimates/sendEstimate/<?php echo $estimate->id ?> " data-target="#modalSmall" data-toggle="modal" class="btn btn-primary pull-right" style="margin-right: 5px;">
                                <i class="fa fa-envelope"></i> <?= lang('email') ?>
                            </a>

                            <a href="<?php echo base_url() ?>admin/estimates/updateSales/<?php echo $estimate->id ?> " class="btn btn-success pull-right" style="margin-right: 5px;">
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