<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><?= lang('add_new_product'); ?></h5>
                </div>
                <?php echo $form->open(); ?>
                <div class="ibox-content">
                    <!-- View massage -->
                    <?php echo $form->messages(); ?>
                    <!-- View massage -->
                    <?php echo message_box('success'); ?>
                    <?php echo message_box('error'); ?>

                    <div class="row">
                        <div class="col-md-7 col-sm-12 col-xs-12 col-md-push-2">
                            <div id="msg"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?= lang('name') ?><span class="required" aria-required="true">*</span></label>
                                                <input type="text" name="name" value="<?php if (!empty($product->name)) echo $product->name ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?= lang('category') ?> <span class="required" aria-required="true">*</span></label>
                                                <select class="form-control select2" name="category_id">
                                                    <span>
                                                        <option value=""><?= lang('please_select') ?>..</option>
                                                        <?php foreach ($categories as $item) { ?>
                                                            <option value="<?php echo $item->id ?>" <?php if (!empty($product->category_id)) echo $item->id === $product->category_id ? 'selected' : '' ?>>
                                                                <?php echo $item->category ?></option>
                                                        <?php } ?>
                                                </select> <a href="#" data-toggle="modal" data-target="#myModal">+ <?= lang('add_category') ?></a></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?= lang('sales_price/rate') ?></label>
                                                <input type="text" name="sales_cost" class="form-control" value="<?php if (!empty($product->sales_cost)) echo $product->sales_cost ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?= lang('buying_cost') ?></label>
                                                <input type="text" name="buying_cost" class="form-control" value="<?php if (!empty($product->buying_cost)) echo $product->buying_cost ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <input type="hidden" name="id" value="<?php if (!empty($product)) echo $product->id ?>">
                            <input type="hidden" name="type" value="<?php echo $type ?>">

                            <a href="javascript::" class="btn btn-primary btn-sm" onclick="save_product()"><?= lang('save') ?></a>

                        </div>
                    </div>


                </div>
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

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?= lang('add_category') ?></h4>
            </div>
            <div class="modal-body">
                <div id="msgModal"></div>
                <form class="form-horizontal" action="<?php echo site_url("admin/product/save_category") ?>" id="form-category">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"><?= lang('category') ?><span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="category" id="p_category">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <a href="javascript::" class="btn btn-primary btn-sm" onclick="save_category()"><?= lang('save') ?></a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-dismiss="modal"><?= lang('close') ?></button>
            </div>
        </div>

    </div>
</div>