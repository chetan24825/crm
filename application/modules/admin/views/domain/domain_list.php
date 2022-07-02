<script src="<?php echo site_url('assets/js/ajax.js') ?>"></script>
<div class="wrapper wrapper-content">
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12" style="margin-bottom: 20px">
                            <?php echo form_open('admin/domain/report', 'class="form-horizontal" method="get"')?>
                                <!-- Filter -->
                                <div class="form-group">
                                    <label for="filter" class="col-sm-2 control-label">Filter</label>
                                    <?php 
                                        $filterList = array(
                                            'domain'   => 'Domain',
                                            'hosting'  => 'Hosting',
                                        );
                                    ?>
                                    <div class="col-sm-10">
                                        <?php echo form_dropdown('filter', $filterList,  $search->filter, "class='form-control' id='filter'") ?>
                                    </div>
                                </div>

                                <!-- Date 2 Date -->
                                <div class="form-group">
                                    <label for="driver_id" class="col-sm-2 control-label">Date</label>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input name="start_date" data-date-format="dd-mm-yyyy" type="text" placeholder="Start Date" value="<?php echo $search->start_date ?>" class="datepicker form-control"/>
                                            </div>

                                            <div class="col-sm-4">
                                                <input name="end_date" data-date-format="dd-mm-yyyy" type="text" placeholder="End Date" value="<?php echo $search->end_date ?>" class="datepicker form-control"/>
                                            </div>

                                            <div class="col-sm-4">
                                                <button type="submit" class="form-control btn btn-success">
                            Search
                            </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo message_box('success');?>
                            <?php echo message_box('error');?>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<script>
    var list = 'admin/domain/domainList';
</script>