<script src="<?php echo site_url('assets/js/ajax.js') ?>"></script>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <?php echo message_box('success'); ?>
            <?php echo message_box('error'); ?>
            <div class="ibox ">
                <div class="ibox-title">
                    <h5><?= lang('franchise_list') ?></h5>
                </div>
                <div class="ibox-content">                    
                    <div class="table-responsive">
                        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?= lang('franchise_id') ?></th>
                                    <th><?= lang('name') ?></th>
                                    <th><?= lang('joined_date') ?></th>
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
    var list        = 'admin/franchise/franchiseTable';
    //var list        = '';
</script>