<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">            
            <?php echo $form->messages(); ?>
            <div class="ibox ">
                <div class="ibox-title">
                    <h5><?= lang('create_user') ?></h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-7 col-sm-12 col-xs-12 col-md-push-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo $form->open(); ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php echo $form->bs3_text(lang('username'), 'username'); ?>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo $form->bs3_text(lang('first_name'), 'first_name'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo $form->bs3_text(lang('last_name'), 'last_name'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo $form->bs3_email(lang('email'), 'email'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo $form->bs3_text(lang('mobile'), 'mobile'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo $form->bs3_password(lang('password'), 'password'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <?php echo $form->bs3_password(lang('retype_password'), 'retype_password'); ?>
                                            </div>
                                        </div>
                                        <?php if (!empty($groups)) : ?>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="groups"><?= lang('group') ?></label>
                                                    <div>
                                                        <select class="form-control" name="groups[]">
                                                            <option value=""><?= lang('select_group') ?>...</option>
                                                            <?php foreach ($groups as $group) : ?>
                                                                <option value="<?php echo $group->id; ?>"><?php echo $group->description; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="box-footer">
                                        <?php echo $form->bs4_submit(lang('submit')); ?>
                                    </div>
                                </div>
                                <?php echo $form->close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>