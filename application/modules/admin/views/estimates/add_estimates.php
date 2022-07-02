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
                        <?php echo $title; ?>
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
                                        <?php if (empty($estimate)) { ?>
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
                                                    <label><?= lang('customer') ?> <span class="required" aria-required="true">*</span></label>
                                                    <select class="form-control select2" style="width: 100%" onchange="get_customer(this)" name="customer_id">
                                                        <option value=""><?= lang('please_select') ?>...</option>
                                                        <?php if (!empty($customers)) {
                                                            foreach ($customers as $item) { ?>
                                                                <option value="<?php echo $item->id ?>" <?php echo  $c_detail->id == $item->id ? 'selected' : '' ?>><?php echo 100 + $item->id . '-' . $item->name ?></option>
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
                                                                <option value="<?php echo $item->id ?>" <?php echo  $estimate->company_id == $item->id ? 'selected' : '' ?>><?php echo 100 + $item->id . '-' . $item->company ?></option>
                                                        <?php };
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- /.Start Date -->
                                                <div class="form-group form-group-bottom">
                                                    <label><?= lang('customer') ?></label>
                                                    <input type="text" class="form-control" value="<?php echo $c_detail->name ?>" readonly>
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
                                                <input type="text" name="state" class="form-control" value="<?php echo !empty($estimate->state) ? $estimate->state : $c_detail->state_name ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('city') ?></label>
                                                <input type="text" name="city" class="form-control" value="<?php echo !empty($estimate->city) ? $estimate->city : $c_detail->city_name ?>">
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
                                        if (!empty($estimate->estimate_date)) {
                                            $estimate_date = date("Y/m/d", strtotime($estimate->estimate_date));
                                        } else {
                                            $estimate_date = date("Y/m/d");
                                        }

                                        if (!empty($estimate->valid_until)) {
                                            $valid_until = date("Y/m/d", strtotime($estimate->valid_until));
                                        } else {
                                            $valid_until = date("Y/m/d");
                                        }
                                        ?>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Estimate Date <span class="required" aria-required="true">*</span></label>
                                                <input name="estimate_date" class="form-control estimate_date" type="text" id="datepicker" data-date-format="yyyy/mm/dd" value="<?php echo $estimate_date ?>">

                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Valid until<span class="required" aria-required="true">*</span></label>
                                                <input name="valid_until" class="form-control valid_until" id="datepicker-1" type="text" data-date-format="yyyy/mm/dd" value="<?php echo $valid_until ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box">
                                <div class="box-body">

                                    <div id="cart_view">
                                        <?php echo $this->view('estimates/add_product_cart'); ?>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="estimate_id" value="<?php if (!empty($estimate)) echo $estimate->id ?>">

                            <?php if (empty($estimate->type)) { ?>
                                <button type="submit" class="btn btn-primary btn-sm" id="saveEstimate"><?= lang('save'); ?> </button>
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
    <?php if (!empty($estimate)) {
        if (($estimate->status === 'Close') || $estimate->status === 'Cancel') { ?>
            $('#from-invoice input, #from-invoice textarea, #from-invoice select').attr('disabled', 'disabled');
            $('#updateInvoice').hide();
            $('#quotation_btn').hide();
    <?php };
    } ?>
</script>