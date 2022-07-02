<!-- Main content -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">

            <!-- View massage -->
            <?php echo message_box('success'); ?>
            <?php echo message_box('error'); ?>

            <div class="ibox">
                <div class="ibox-title">
                    <h3 class="box-title">
                        <?php if ($type === 'invoice') { ?>
                        <?= lang('create_sales_invoice');
                        } else { ?>
                        <?= lang('create_quotation');
                        } ?>

                    </h3>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->

                <?php echo $form->open(); ?>
                <div class="ibox-content">

                    <!-- View massage -->
                    <?php echo $form->messages(); ?>
                    <!-- View massage -->
                    <?php echo message_box('success'); ?>
                    <?php echo message_box('error'); ?>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div id="msg"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Order Number</label>
                                                    <input type="text" class="form-control" name="order_number" value="<?php echo $order->order_no ?>">
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row">
                                        <?php if (empty($order)) { ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?= lang('company') ?> <span class="required" aria-required="true">*</span></label>
                                                    <select class="form-control select2" style="width: 100%" name="company_id">
                                                        <option value=""><?= lang('please_select') ?>...</option>
                                                        <?php if (!empty($companies)) {
                                                            foreach ($companies as $item) { ?>
                                                                <option value="<?php echo $item->id ?>" <?php echo  $c_detail->id == $item->id ? 'selected' : '' ?>><?php echo 100 + $item->id . '-' . $item->company ?></option>
                                                        <?php };
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?= lang('company') ?> <span class="required" aria-required="true">*</span></label>
                                                    <select class="form-control select2" style="width: 100%" onchange="get_customer(this)" name="customer_id">
                                                        <option value=""><?= lang('please_select') ?>...</option>
                                                        <?php if (!empty($customers)) {
                                                            foreach ($customers as $item) { ?>
                                                                <option value="<?php echo $item->id ?>" <?php echo  $c_detail->id == $item->id ? 'selected' : '' ?>><?php echo 100 + $item->id . '-' . $item->company_name ?></option>
                                                        <?php };
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group form-group-bottom">
                                                    <label><?= lang('website') ?></label>
                                                    <input type="text" class="form-control" name="website" value="<?php echo $c_detail->website ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group form-group-bottom">
                                                    <label>GST Number</label>
                                                    <input type="text" class="form-control" name="company_gst" value="<?php echo $c_detail->company_gst ?>">
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?= lang('company') ?> <span class="required" aria-required="true">*</span></label>
                                                    <select class="form-control select2" style="width: 100%" name="company_id">
                                                        <option value=""><?= lang('please_select') ?>...</option>
                                                        <?php if (!empty($companies)) {
                                                            foreach ($companies as $item) { ?>
                                                                <option value="<?php echo $item->id ?>" <?php echo  $order->company_id == $item->id ? 'selected' : '' ?>><?php echo 100 + $item->id . '-' . $item->company ?></option>
                                                        <?php };
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- /.Start Date -->
                                                <div class="form-group form-group-bottom">
                                                    <label><?= lang('company') ?></label>
                                                    <input type="text" class="form-control" value="<?php echo $c_detail->company_name ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <!-- /.Start Date -->
                                                <div class="form-group form-group-bottom">
                                                    <label><?= lang('website') ?></label>
                                                    <input type="text" class="form-control" name="website" value="<?php echo $c_detail->website ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group form-group-bottom">
                                                    <label>GST Number</label>
                                                    <input type="text" class="form-control" name="company_gst" value="<?php echo $c_detail->company_gst ?>">
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('email') ?></label>
                                                <input type="text" name="email" class="form-control" value="<?php echo $c_detail->email ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('phone') ?></label>
                                                <input type="text" name="phone" class="form-control" value="<?php echo "+" . $c_detail->phone_code . $c_detail->phone_1 ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('state') ?></label>
                                                <input type="text" name="state" class="form-control" value="<?php echo !empty($order->state) ? $order->state : $c_detail->state_name ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('city') ?></label>
                                                <input type="text" name="city" class="form-control" value="<?php echo !empty($order->city) ? $order->city : $c_detail->city_name ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?= lang('address') ?></label>
                                                <textarea class="form-control" name="address"><?php echo nl2br($c_detail->address) ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php
                                        if (!empty($order->invoice_date)) {
                                            $invoice_date = date("Y/m/d", strtotime($order->invoice_date));
                                        } else {
                                            $invoice_date = date("Y/m/d");
                                        }

                                        if (!empty($order->due_date)) {
                                            $due_date = date("Y/m/d", strtotime($order->due_date));
                                        } else {
                                            $due_date = date("Y/m/d");
                                        }
                                        ?>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><?= lang('invoice_date') ?> <span class="required" aria-required="true">*</span></label>
                                                <input name="invoice_date" class="form-control invoice_date" type="text" id="datepicker" data-date-format="yyyy/mm/dd" value="<?php echo $invoice_date ?>">

                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><?= lang('due_date') ?><span class="required" aria-required="true">*</span></label>
                                                <input name="due_date" class="form-control due_date" id="datepicker-1" type="text" data-date-format="yyyy/mm/dd" value="<?php echo $due_date ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if (!empty($order)) { ?>
                                    <div class="col-md-6">
                                        <div class="row" style="padding-left: 70px">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <?php
                                                    $company = $this->global_model->select_field_where_db('company', array('id =' . $order->company_id), 'company');
                                                    $words = explode(' ', $company); $cmp = $words[0][0]. $words[1][0];
                                                    ?>
                                                    <?php if ($type != 'quotation') { ?>
                                                        <?php if(!empty($order->order_no)) { ?>
                                                             <h3><?= get_option('invoice_prefix') ?><?= $order->order_no ?></h3><br>
                                                         <?php }else{ ?>
                                                            <h3><?= get_option('invoice_prefix') ?><?= $cmp ?><?= INVOICE_PRE + $order->id ?></h3><br>
                                                        <?php } ?>
                                                        <br>
                                                        <b><?= lang('order_date') ?>:</b> <?php echo $this->localization->dateFormat($order->invoice_date) ?><br>
                                                        <b><?= lang('payment_due') ?>:</b> <?php echo $this->localization->dateFormat($order->due_date) ?><br><br>
                                                        <?php if ($order->status != 'Cancel') { ?>
                                                            <p class="lead"><?= lang('received_amount') ?>: <?= get_option('currency_symbol') . ' ' . $this->localization->currencyFormat($order->amount_received) ?></p>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <h3><?= lang('quotation') ?># <?= INVOICE_PRE + $order->id ?></h3><br>
                                                        <b><?= lang('estimate_date') ?>:</b> <?php echo $this->localization->dateFormat($order->invoice_date) ?><br>
                                                        <b><?= lang('expiration_date') ?>:</b> <?php echo $this->localization->dateFormat($order->due_date) ?><br>
                                                    <?php } ?>

                                                    <?php if ($order->status === 'Cancel') { ?>
                                                        <p class="lead"><?= lang('status') ?>: <span style="color: red"><?= lang('canceled') ?></span></p>
                                                    <?php } ?>

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="box">
                                <div class="box-body">

                                    <div id="cart_view">
                                        <?php echo $this->view('sales/cart/add_product_cart'); ?>
                                    </div>

                                    <div class="row">
                                        <?php if (!empty($order)) { ?>
                                            <?php if ($order->status == 'Cancel') { ?>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><?= lang('cancellation_note') ?></label><br />
                                                        <?php echo $order->cancel_note ?>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Order Note</label>
                                                        <textarea class="form-control" name="order_note"><?php if (!empty($order)) echo $order->order_note ?></textarea>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?= lang('order_note') ?></label>
                                                    <textarea class="form-control" name="order_note"><?php if (!empty($order)) echo $order->order_note ?></textarea>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?= lang('order_activities') ?></label>
                                                <textarea class="form-control" name="order_activities"><?php if (!empty($product->sales_info)) echo $product->sales_info ?></textarea>
                                            </div>
                                        </div>


                                    </div>



                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <input type="hidden" name="type" value="<?php if (!empty($type)) echo $type ?>">
                            <input type="hidden" name="order_id" value="<?php if (!empty($order)) echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($order->id)) ?>">

                            <?php if (empty($order->type)) { ?>
                                <button type="submit" class="btn btn-primary btn-sm" id="saveInvoice"><?= lang('save'); ?> </button>
                            <?php } else { ?>
                                <button type="submit" class="btn btn-primary btn-sm" id="updateInvoice"><?= lang('update') ?></button>
                            <?php } ?>

                        </div>
                    </div>


                </div>
                <!-- /.box-body -->

                <div class="box-footer">

                </div>
                <?php echo $form->close(); ?>

            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<!-- /.content -->



<script lang="javascript">
    $(document).ready(function() {
        //***************** Tier Price Option Start *****************//
        $(".addTire").click(function() {
            $("#tireFields").append(
                '<tr>\
                    <td>\
                <div class="form-group form-group-bottom">\
                1\
                </div>\
                </td>\
                    <td>\
                <div class="form-group form-group-bottom p_div">\
                <select class="form-control select2" style="width: 100%">\
                <option value="">Select..</option>\
                <?php if (!empty($products)) {
                    foreach ($products as $key => $product) { ?>\
                <optgroup label="<?php echo $key ?>">\
                <?php foreach ($product as $item) { ?>\
                <option value="<?php echo $item->id  ?>"><?php echo $item->name ?></option>\
                <?php } ?>\
                </optgroup>\
                <?php };
                } ?>\
                </select>\
                </div>\
                </td>\
                <td>\
                <div class="form-group form-group-bottom">\
                <input class="form-control" type="text">\
                </div>\
                </td>\
                <td>\
                <div class="form-group form-group-bottom">\
                <input class="form-control" type="text">\
                </div>\
                </td>\
                <td>\
                <div class="form-group form-group-bottom">\
                <input class="form-control" type="text">\
            </div>\
            </td>\
            <td>\
            <div class="form-group form-group-bottom">\
                <input class="form-control" type="text" readonly>\
            </div>\
            </td>\
            <td><a href="javascript:void(0);" class="remTire" style="color: red"><i class="glyphicon glyphicon-trash"></i></a></td>\
            </tr>'
            );

            set();

        });
        //***************** Tire Price Option End *****************//

        //Remove Tire Fields
        $("#tireFields").on('click', '.remTire', function() {
            $(this).parent().parent().remove();
        });

        function set() {
            //$("#product").select2();
            $('select').select2();
        }

    });
</script>

<style>
    .date-element {
        display: block;
        top: 439.267px;
        right: 962px;
        left: auto;
    }
</style>

<script>
    $("#quotation_btn").on("click", function(e) {
        e.preventDefault();
        $('#from-invoice').attr('action', "sales/save_sales").submit();
    });
    <?php if (!empty($order)) {
        if (($order->status === 'Close') || $order->status === 'Cancel') { ?>
            $('#from-invoice input, #from-invoice textarea, #from-invoice select').attr('disabled', 'disabled');
            $('#updateInvoice').hide();
            $('#quotation_btn').hide();
    <?php };
    } ?>
</script>