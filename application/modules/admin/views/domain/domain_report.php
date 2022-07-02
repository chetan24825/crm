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
                                        <?php echo form_dropdown('filter', $filterList,  $search->filter, "class='form-control select2' id='filter'") ?>
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
                                        <?php if($search->filter ==='domain'){ ?>
                                        <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>SL. No.</th>
                                                    <th>
                                                        Customer
                                                    </th>
                                                    <th>
                                                        Company
                                                    </th>
                                                    <th>Domain</th>
                                                    <th>
                                                        Renewal Date
                                                    </th>
                                                    <th style="width:125px;">
                                                        
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($reports)){?>
                                                    <?php $sl = 1; $status = ''; ?>
                                                    <?php foreach ($reports as $report) { 
                                                    if ($report->active == 1){
                                                        $status = 'Active';
                                                        $class = 'bg-olive-active';
                                                    }else{
                                                        $status = 'Expired';
                                                        $class = 'bg-red-active';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sl++; ?></td>
                                                        <td><a href="<?php echo base_url('admin/customer/customerDetails?tab=domain').'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($report->customer_id)) ?>"><?php echo $report->customer_name; ?><br/><small><?php echo '('.trim($report->contact_number).')'; ?></small></a></td>
                                                        <td><?php echo $report->company_name; ?></td>
                                                        <td><a href="<?php echo base_url('admin/customer/customerDetails?tab=domain').'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($report->customer_id)) ?>"><?php echo '<strong>'.$report->domain_name.'</strong>'; ?></a></td>
                                                        <td><?php echo $this->localization->dateFormat($report->renewal_date); ?></td>
                                                        <td><span class="label <?php echo $class; ?>"><?php echo $status; ?></span></td>
                                                    </tr>
                                                    <?php } ?> 
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php } ?>
                                        <?php if($search->filter ==='hosting'){ ?>
                                        <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>SL. No.</th>
                                                    <th>
                                                        Customer
                                                    </th>
                                                    <th>
                                                        Company
                                                    </th>
                                                    <th>Domain</th>
                                                    <th>
                                                        Renewal Date
                                                    </th>
                                                    <th style="width:125px;">
                                                        
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($reports)){?>
                                                    <?php $sl = 1; $status = ''; ?>
                                                    <?php foreach ($reports as $report) { 
                                                    if ($report->active == 1){
                                                        $status = 'Active';
                                                        $class = 'bg-olive-active';
                                                    }else{
                                                        $status = 'Expired';
                                                        $class = 'bg-red-active';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sl++; ?></td>
                                                        <td><a href="<?php echo base_url('admin/customer/customerDetails?tab=domain').'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($report->customer_id)) ?>"><?php echo $report->customer_name; ?><br/><small><?php echo '('.trim($report->contact_number).')'; ?></small></a></td>
                                                        <td><?php echo $report->company_name; ?></td>
                                                        <td><a href="<?php echo base_url('admin/customer/customerDetails?tab=domain').'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($report->customer_id)) ?>"><?php echo '<strong>'.$report->hosting_company.'</strong> - ('.$report->hosting_space.')'; ?></a></td>
                                                        <td><?php echo $this->localization->dateFormat($report->renewal_date); ?></td>
                                                        <td><span class="label <?php echo $class; ?>"><?php echo $status; ?></span></td>
                                                    </tr>
                                                    <?php } ?> 
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php } ?>
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