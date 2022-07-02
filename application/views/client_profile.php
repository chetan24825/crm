
<div class="row">



    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?= lang('profile') ?></h3>
            </div>
            <div class="box-body">

                <table class="table table-bordered">
                    <tr>
                        <th><?= lang('name') ?>: </th>
                        <td><?php echo $customer->name; ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('company') ?>: </th>
                        <td><?php echo $customer->company_name; ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('country') ?>: </th>
                        <td><?php echo $customer->country_name ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('state') ?>: </th>
                        <td><?php echo $customer->state_name ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('city') ?>: </th>
                        <td><?php echo $customer->city_name ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('postal_code') ?>: </th>
                        <td><?php echo $customer->zipcode ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('email') ?>: </th>
                        <td><?php echo $customer->email ?></td>
                    </tr>

                </table>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?= lang('update_password') ?> </h3>
            </div>
            <div class="box-body">
                <!-- View massage -->
                <?php echo message_box('success'); ?>
                <?php echo message_box('error'); ?>

                <?php echo form_open('employee/profile/reset_password'); ?>
                <div class="form-group">
                    <label><?= lang('password') ?><span class="required">*</span></label>
                    <input type="password" class="form-control" name="password">
                </div>

                <div class="form-group">
                    <label><?= lang('retype_password') ?><span class="required">*</span></label>
                    <input type="password" name="retype_password" class="form-control" >
                </div>
                <button id="saveSalary" type="submit" class="btn bg-olive btn-flat"  >
                    <?php echo lang('update_password'); ?>
                </button>
                <?php echo form_close()?>
            </div>
        </div>
    </div>

</div>