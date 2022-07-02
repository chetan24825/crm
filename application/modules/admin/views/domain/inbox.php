<script src="<?php echo site_url('assets/js/ajax.js') ?>"></script>



<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">

            <?php echo message_box('success'); ?>
            <?php echo message_box('error'); ?>
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="<?php echo base_url('admin/domain'); ?>">Domains</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('admin/hosting'); ?>">Hostings</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="panel-body">
                        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?= lang('customer') ?></th>
                                    <th><?= lang('company') ?></th>
                                    <th>Domain</th>
                                    <th><?= lang('renewal_date') ?></th>
                                    <th style="width:125px;"><?= lang('status') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
</section>
<!-- /.content -->
<script>
    //var table;
    var list = 'admin/domain/domainList';
</script>