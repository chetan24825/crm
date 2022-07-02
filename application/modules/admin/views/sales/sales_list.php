<!-- Main content -->
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-2">
            <div class="ibox ">
                <div class="ibox-title">
                    <span class="label label-info float-right"><?php echo strtoupper(lang('open_invoice')) ?></span>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $this->localization->currencyFormat($openInvoice->invoice_amount) ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <!-- View massage -->
            <?php echo message_box('success'); ?>
            <?php echo message_box('error'); ?>

            <div class="ibox">
                <div class="ibox-title">
                    <h3 class="box-title"><?= lang('invoice_list') ?></h3>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <?php
                foreach ($crud->css_files as $file) : ?>
                    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
                <?php endforeach; ?>

                <?php foreach ($crud->js_files as $file) : ?>
                    <script src="<?php echo $file; ?>"></script>
                <?php endforeach; ?>

                <div class="ibox-content">
                    <?php echo $crud->output; ?>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- /.content -->