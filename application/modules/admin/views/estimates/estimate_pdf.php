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
                                    <?php
                                        $comp = $this->global_model->select_field_where_db('company', array('id =' . $estimate->company_id), 'company');
                                        $words = explode(' ', $comp); $cmp = $words[0][0]. $words[1][0];
                                     ?>
                                    <h2>Estimate #<?= ESTIMATE_PRE + $estimate->id ?></h2>
                                    <b>Estimate Date:</b> <?php echo $this->localization->dateFormat($estimate->estimate_date) ?><br>
                                    <b>Expiration Date:</b> <?php echo $this->localization->dateFormat($estimate->valid_until) ?><br>
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
                                <strong>Estimate To</strong>
                                <address>
                                    <strong><?= $customer->name ?></strong><br>
                                    <?= !empty($estimate->city) ? $estimate->city : $customer->city_name ?>                                    
                                    <?= ", ".!empty($estimate->state) ? $estimate->state : $customer->state_name ?>
                                    <br>
                                    <?= !empty($estimate->address) ? $estimate->address : $customer->address ?><br>
                                    <?= lang('phone') ?>: <?= "+".$customer->phone_code.$customer->phone_1 ?><br>
                                    <?= lang('email') ?>: <?= $customer->email ?><br>
                                    <?php if(!empty($estimate->gst)){ ?>
                                    GST Number : <?= $estimate->gst ?>
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
            foreach ($estimate_details as $item) { ?>
                <tr class="item">
                    <td><?= $i ?></td>
                    <td>
                        <?= $item->product_name ?>
                        <br>
                        <small><?= $item->description ?></small>
                    </td>
                    <td><?= $item->qty ?></td>
                    <td><?= $item->price ?></td>
                    <td><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($item->price * $item->qty) ?></td>
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
                    <?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($estimate->cart_total) ?>
                </td>
            </tr>
            <?php if ($estimate->tax > 0) { ?>
                <tr class="total">
                    <td></td>
                    <td colspan="2" align="right" style="border-bottom:solid 1px #eee"><?= lang('tax') ?>:</td>
                    <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($estimate->tax) ?></td>
                </tr>
            <?php } ?>
            <?php if ($estimate->gst_tax > 0) { ?>
                <?php $gst_amount = ($estimate->cart_total * $estimate->gst_tax) / 100; ?>
                <tr class="total">
                    <td></td>
                    <td colspan="2" align="right" style="border-bottom:solid 1px #eee">GST:</td>
                    <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($gst_amount) ?> (<?= $estimate->gst_tax ?>%)</td>
                </tr>
            <?php } ?>
            <?php if ($estimate->cgst_tax > 0) { ?>
                <?php $cgst_amount = ($estimate->cart_total * $estimate->cgst_tax) / 100; ?>
                <tr class="total">
                    <td></td>
                    <td colspan="2" align="right" style="border-bottom:solid 1px #eee">CGST:</td>
                    <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($cgst_amount) ?> (<?= $estimate->cgst_tax ?>%)</td>
                </tr>
            <?php } ?>
            <?php if ($estimate->sgst_tax > 0) { ?>
                <?php $sgst_amount = ($estimate->cart_total * $estimate->sgst_tax) / 100; ?>
                <tr class="total">
                    <td></td>
                    <td colspan="2" align="right" style="border-bottom:solid 1px #eee">SGST:</td>
                    <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($sgst_amount) ?> (<?= $estimate->sgst_tax ?>%)</td>
                </tr>
            <?php } ?>
            <?php if ($estimate->igst_tax > 0) { ?>
                <?php $igst_amount = ($estimate->cart_total * $estimate->igst_tax) / 100; ?>
                <tr class="total">
                    <td></td>
                    <td colspan="2" align="right" style="border-bottom:solid 1px #eee">IGST:</td>
                    <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($igst_amount) ?> (<?= $estimate->igst_tax ?>%)</td>
                </tr>
            <?php } ?>
            <?php if($estimate->discount > 0){ ?>
                <?php $discount_amount = ($estimate->cart_total * $estimate->discount) / 100; ?>
                <tr class="total">
                    <td></td>
                    <td colspan="2" align="right" style="border-bottom:solid 1px #eee"><?= lang('discount') ?>:</td>
                    <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol') . ' - ' . $this->localization->currencyFormat($discount_amount) ?></td>
                </tr>
            <?php } ?>
            <tr class="total">
                <td></td>
                <td colspan="2" align="right" style="border-bottom:solid 1px #eee"><?= lang('grand_total') ?>:</td>
                <td style="border-bottom:solid 1px #eee"><?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($estimate->grand_total) ?></td>
            </tr>
        </table>

        <br />
        <table cellpadding="0" cellspacing="0">
            <tr class="order_note">
                <?php if (!empty($estimate->order_note)) { ?>
                    <td height="110"><strong><?= lang('order_note') ?>:</strong><br>
                        <small> <?= $estimate->order_note ?> </small></td>
                <?php } ?>
            </tr>
            <tr class="total">
                <td><?php echo get_option('invoice_text') ?></td>
            </tr>
        </table>

    </div>
</body>
</html>