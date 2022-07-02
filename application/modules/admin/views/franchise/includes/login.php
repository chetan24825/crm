<?php
if (!empty($login)) {
    echo form_open('admin/franchise/reset_password');
} else {
    echo form_open('admin/franchise/create_user');
}
?>

<div class="panel-body">
    <div class="col-md-7 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label><?= lang('loginid') ?></label>
                    <input type="text" class="form-control" name="username" value="<?php if (!empty($franchise->franchise_id)) echo $franchise->franchise_id ?>" disabled>

                </div>

                <div class="form-group">
                    <label><?= lang('password') ?><span class="required">*</span></label>
                    <input type="password" class="form-control" name="password">
                </div>

                <div class="form-group">
                    <label><?= lang('retype_password') ?><span class="required">*</span></label>
                    <input type="password" name="retype_password" class="form-control">
                </div>

                <?php if ($franchise->termination) { ?>

                    <?php if (!empty($login->id)) : ?>
                        <div class="form-group">
                            <label><?= lang('active_deactive') ?></label>
                            <label class="css-input switch switch-sm switch-success">
                                <input id="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($login->id)) ?>" <?php echo $login->active == 1 ? 'checked' : '' ?> type="checkbox" onclick='employeeActivation(this)'><span></span>
                            </label>
                        </div>
                    <?php endif ?>
                <?php } ?>
            </div>
        </div>

        <input type="hidden" name="id" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($franchise->id)) ?>">
        <?php if (!empty($login->id)) : ?>
            <input type="hidden" name="login_id" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($login->id)) ?>">
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