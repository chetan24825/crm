<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link href='<?php echo base_url() ?>assets/css/invoice.css' rel='stylesheet' media='screen'>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="6">
                    <table>
                        <tr>
                            <td class="title">
                                <?php $company_logo = get_option('company_logo') ?>
                                <img src="<?php echo base_url('assets/uploads/logo/invoice-logo.png') ?>" class="img img-responsive">
                            </td>

                            <td align="right">
                                <?php if ($type != 'Quotation') { ?>
                                    <?php
                                        $comp = $this->global_model->select_field_where_db('company', array('id =' . $order->company_id), 'company');
                                        $words = explode(' ', $comp); $cmp = $words[0][0]. $words[1][0];
                                     ?>
                                     <?php if(!empty($order->order_no)) { ?>
                                         <h2><?= get_option('invoice_prefix') ?><?= $order->order_no ?></h2>
                                     <?php }else{ ?>
                                        <h2><?= get_option('invoice_prefix') ?><?= $cmp ?><?= INVOICE_PRE + $order->id ?></h2>
                                    <?php } ?>
                                    <b><?= lang('order_date') ?>:</b> <?php echo $this->localization->dateFormat($order->invoice_date) ?><br>
                                    <b><?= lang('payment_due') ?>:</b> <?php echo $this->localization->dateFormat($order->due_date) ?><br>
                                <?php } else { ?>
                                    <h2><?= lang('quotation') ?># <?= INVOICE_PRE + $order->id ?></h2>
                                    <b><?= lang('estimate_date') ?>: </b> <?php echo $this->localization->dateFormat($order->invoice_date) ?><br>
                                    <b><?= lang('expiration_date') ?>: </b> <?php echo $this->localization->dateFormat($order->due_date) ?><br>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="6">
                    <table>
                        <tr>
                            <td style="width:300px">
                                From
                                <address>
                                    <strong><?= $company->company ?></strong><br>
                                    <p class="company_address"><?= $company->company_address ?></p>
                                    <?php if (!empty($company->company_gst)) { ?>
                                        <b>Company GST :</b>: <?= $company->company_gst ?><br>
                                    <?php } ?>
                                </address>
                            </td>
                            <td align="right">
                                To
                                <address>
                                    <strong><?= $customer->company_name ?></strong><br>
                                    <?= $customer->city_name . ", " . $customer->state_name ?>
                                    <br>
                                    <?= $order->address ?><br>
                                    <?= lang('phone') ?>: <?= "+".$customer->phone_code.$customer->phone_1 ?>
                                    <?php if (!empty($order->email)) { ?>
                                        <?= lang('email') ?>: <?= $order->email ?><br>
                                    <?php } ?>
                                    <?php if (!empty($order->gst)) { ?>
                                        GST Number : <?= $order->gst ?><br>
                                    <?php } ?>
                                </address>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td width="2%">#</td>
                <td width="57%"> <?= lang('item') ?> </td>
                <td width="14%"><?= lang('qty') ?></td>
                <td width="16%">Unit Price</td>
                <td width="18%"><?= lang('total') ?></td>
            </tr>
            <?php $i = 1;
            foreach ($order_details as $item) { ?>
                <tr class="item">
                    <td><?= $i ?></td>
                    <td>
                        <?= $item->product_name ?>
                        <br>
                        <small><?= $item->description ?></small>
                    </td>
                    <td><?= $item->qty ?></td>
                    <td><?= $item->sales_cost ?></td>
                    <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($item->sales_cost * $item->qty) ?></td>
                </tr>
            <?php $i++;
            } ?>

            <tr class="total">
                <td></td>
                <td rowspan="6">
                    <table width="70%" border="0" cellspacing="2">

                        <tr class="order_note">
                            <td height="110"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr style="border:solid 1px #ccc;">
                            <td></td>
                        </tr>
                    </table>
                </td>
                <td colspan="2" align="right" style="border-bottom:solid 1px #eee"><?= lang('subtotal') ?>: </td>
                <td style="border-bottom:solid 1px #eee">
                    <?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($order->cart_total) ?>
                </td>
            </tr>
            <?php if ($order->tax > 0) { ?>
                <tr class="total">
                    <td></td>
                    <td colspan="2" align="right" style="border-bottom:solid 1px #eee"><?= lang('tax') ?>:</td>
                    <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($order->tax) ?></td>
                </tr>
            <?php } ?>
            <?php if ($order->gst_tax > 0) { ?>
                <?php $gst_amount = ($order->cart_total * $order->gst_tax) / 100; ?>
                <tr class="total">
                    <td></td>
                    <td colspan="2" align="right" style="border-bottom:solid 1px #eee">GST:</td>
                    <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($gst_amount) ?> (<?= $order->gst_tax ?>%)</td>
                </tr>
            <?php } ?>
            <?php if ($order->cgst_tax > 0) { ?>
                <?php $cgst_amount = ($order->cart_total * $order->cgst_tax) / 100; ?>
                <tr class="total">
                    <td></td>
                    <td colspan="2" align="right" style="border-bottom:solid 1px #eee">CGST:</td>
                    <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($cgst_amount) ?> (<?= $order->cgst_tax ?>%)</td>
                </tr>
            <?php } ?>
            <?php if ($order->sgst_tax > 0) { ?>
                <?php $sgst_amount = ($order->cart_total * $order->sgst_tax) / 100; ?>
                <tr class="total">
                    <td></td>
                    <td colspan="2" align="right" style="border-bottom:solid 1px #eee">SGST:</td>
                    <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($sgst_amount) ?> (<?= $order->sgst_tax ?>%)</td>
                </tr>
            <?php } ?>
            <?php if ($order->igst_tax > 0) { ?>
                <?php $igst_amount = ($order->cart_total * $order->igst_tax) / 100; ?>
                <tr class="total">
                    <td></td>
                    <td colspan="2" align="right" style="border-bottom:solid 1px #eee">IGST:</td>
                    <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($igst_amount) ?> (<?= $order->igst_tax ?>%)</td>
                </tr>
            <?php } ?>
            <?php if($order->discount > 0){ ?>
                <?php $discount_amount = ($order->cart_total * $order->discount) / 100; ?>
                <tr class="total">
                    <td></td>
                    <td colspan="2" align="right" style="border-bottom:solid 1px #eee"><?= lang('discount') ?>:</td>
                    <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol') . ' - ' . $this->localization->currencyFormat($discount_amount) ?></td>
                </tr>
            <?php } ?>
            <tr class="total">
                <td></td>
                <td colspan="2" align="right" style="border-bottom:solid 1px #eee"><?= lang('grand_total') ?>:</td>
                <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($order->grand_total) ?></td>
            </tr>
            <?php if ($order->amount_received > 0) { ?>
                <tr class="total">
                    <td></td>
                    <td colspan="2" align="right" style="border-bottom:solid 1px #eee"><?= lang('received_amount') ?>:</td>
                    <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($order->amount_received) ?></td>
                </tr>
            <?php } ?>
            <tr class="total">
                <td></td>
                <td colspan="2" align="right" style="border-bottom:solid 1px #eee"><?= lang('amount_due') ?>:</td>
                <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($order->due_payment) ?> </td>
            </tr>
        </table>

        <br />
        <table cellpadding="0" cellspacing="0">
            <tr class="order_note">
                <?php if (!empty($order->order_note)) { ?>
                    <td height="110"><strong><?= lang('order_note') ?>:</strong><br>
                        <small> <?= $order->order_note ?> </small></td>
                <?php } ?>
            </tr>
            <tr class="total">
                <td><?php echo get_option('invoice_text') ?></td>
            </tr>
        </table>
        <?php if (!empty($payment)) { ?>
            <table cellpadding="0" cellspacing="0">

                <tr class="heading">
                    <td><?= lang('date') ?></td>
                    <td><?= lang('payment_ref') ?>.</td>
                    <td><?= lang('payment_method') ?></td>
                    <td><?= lang('amount') ?></td>

                </tr>
                <?php foreach ($payment as $id) { ?>
                    <tr class="total">
                        <td><?php dateFormat($id->payment_date) ?></td>
                        <td><?php echo $id->payment_ref ?></td>
                        <td><?php echo $id->payment_method ?></td>
                        <td><?php echo currency($id->amount) ?></td>
                    </tr>
                <?php } ?>


            </table>
        <?php } ?>
        <br/>
        <table cellpadding="0" cellspacing="0">
            <tbody>
                <tr class="order_note">
                    <td height="110">
                        <?php if(!empty($company->bankinfo)){ ?>
                            <strong>Bank Info</strong><br>
                            <p class="company_address"><?= $company->bankinfo ?></p>
                        <?php } ?>
                        <?php if(!empty($company->paytm)){ ?>
                           <p style="display:flex; align-items:center;"><img src="<?php echo base_url('assets/images/paytm.png') ?>" class="img img-responsive"> &nbsp;&nbsp;&nbsp;<?= $company->paytm ?></p>
                        <?php } ?>
                        <?php if(!empty($company->googlepay)){ ?>
                            <p style="display:flex; align-items:center;"><img src="<?php echo base_url('assets/images/googlepay.png') ?>" class="img img-responsive"> &nbsp;&nbsp;&nbsp; <?= $company->googlepay ?><p>
                        <?php } ?>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</body>
</html>