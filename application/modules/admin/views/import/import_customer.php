<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5><?= lang('import_customer') ?></h5>
                        </div>
                        <div class="ibox-content table-responsive">
                        <?php echo $form->open(); ?>
                        <?php echo $form->messages(); ?>
                        <!-- View massage -->
                        <?php echo message_box('success'); ?>
                        <?php echo message_box('error'); ?>
                        <div id="msg"></div>
                                <strong><?= lang('download_sample_csv_file') ?></strong><br />
                                <a href="<?php echo site_url('admin/customer/downloadCustomerSample')?>"><i class="fa fa-download" aria-hidden="true"></i> <?= lang('sample_csv_file') ?></a>
                                <br />
                                <br />
                                <div class="form-group">
                                    <label><?= lang('import_customer') ?></label>
                                    <input type="file" name="import" class="form-control">
                                </div>
                            <input class="btn btn-primary btn-sm" name="submit" type="submit" value="<?= lang('import') ?>">
                        <?php echo $form->close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


