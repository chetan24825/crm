<?php
if (!empty($login)) {
    echo form_open('admin/customer/reset_password');
} else {
    echo form_open('admin/customer/create_user');
}
?>

<div class="panel-body">
    <div class="col-md-7 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label><?= lang('loginemail') ?></label>
                    <input type="text" class="form-control" name="email" value="<?php if (!empty($customer->email)) echo $customer->email ?>" disabled>
                </div>

                <div class="form-group">
                    <label><?= lang('password') ?><span class="required">*</span></label>
                    <input type="password" class="form-control" name="password">
                </div>

                <div class="form-group">
                    <label><?= lang('retype_password') ?><span class="required">*</span></label>
                    <input type="password" name="retype_password" class="form-control">
                </div>
            </div>
        </div>

        <input type="hidden" name="id" value="<?php echo $customer->id; ?>">
        <?php if (!empty($login->id)) : ?>
            <input type="hidden" name="login_id" value="<?php echo $login->id; ?>">
        <?php endif ?>
        <div class="box-footer">

        <button id="saveSalary" type="submit" class="btn bg-olive btn-flat">
            <?php if (!empty($login)) {
                echo lang('update_password');
            } else {
                echo lang('create_login');
            }
            ?>
        </button>
    </div>
    </div>
</div>
<?php echo form_close() ?>