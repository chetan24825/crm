<script src="<?php echo site_url('assets/js/ajax.js') ?>"></script>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <?php echo message_box('success'); ?>
            <?php echo message_box('error'); ?>
            <div class="ibox ">
                <div class="ibox-title">
                    <h5><?= lang('product_list') ?></h5>
                    <div class="ibox-tools">
                        <a href="<?php echo base_url() . 'admin/product/productType?type=service' ?>" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> <?= lang('add_new_product') ?></a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?= lang('product_id') ?></th>
                                    <th><?= lang('product') ?></th>
                                    <th><?= lang('sales_cost') ?></th>
                                    <th><?= lang('buying_cost') ?></th>
                                    <th style="width:125px;"><?= lang('actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //var table;
    var list = 'admin/product/productTable';
    //var list        = '';
</script>