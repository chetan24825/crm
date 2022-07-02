<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5><?= lang('add_franchise') ?></h5>
                    <div class="ibox-tools">
                        <a href="<?php echo base_url('admin/franchise/importFranchise') ?>" class="btn btn-warning"><i class="fa fa-upload" aria-hidden="true"></i> <?= lang('import') ?></a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php echo $form->open(); ?>
                    <?php echo $form->messages(); ?>
                    <!-- View massage -->
                    <?php echo message_box('success'); ?>
                    <?php echo message_box('error'); ?>
                    <div class="row">
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('first_name') ?><span class="required" aria-required="true">*</span></label>
                                        <input type="text" name="first_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('last_name') ?><span class="required" aria-required="true">*</span></label>
                                        <input type="text" name="last_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                            <label><?= lang('address_street') ?><span class="required">*</span></label>
                                            <input type="text" name="address" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('city') ?> <span class="required">*</span></label>
                                        <input type="text" name="city" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('state_province') ?><span class="required">*</span></label>
                                        <input type="text" name="state" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('zip_postal_code') ?><span class="required">*</span></label>
                                        <input type="text" name="postal" class="form-control">
                                    </div>
                                    <hr/>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('country') ?><span class="required" aria-required="true">*</span></label>
                                        <select class="form-control select2" name="country">
                                            <option value=""><?= lang('please_select') ?>..</option>
                                            <?php foreach ($countries as $item) { ?>
                                                <option value="<?php echo $item->country ?>"><?php echo $item->country ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <hr/>
                                </div>
                                <hr/>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('work_telephone') ?></label>
                                        <input type="text" name="work_telephone" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('work_email') ?></label>
                                        <input type="text" name="work_email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('mobile') ?></label>
                                        <input type="text" name="mobile" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= lang('other_email') ?></label>
                                        <input type="text" name="other_email" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label><?= lang('joined_date') ?><span class="required">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="datepicker3" name="joined_date" data-date-format="yyyy/mm/dd">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar-o"></i>
                                                </div>
                                            </div>
                                    </div>
                                </div>                                

                            </div>

                            <p class="text-muted"><span class="required" aria-required="true">*</span>Required field</p>

                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <?php //echo $form->bs4_submit(lang('save_franchise')); ?>
                            <button id="saveFranchise" type="submit" class="btn btn-primary btn-sm "><?= lang('save_franchise') ?></button>
                        </div>
                    </div>
                    <?php echo $form->close(); ?>
                </div>
                
            </div>
        </div>
    </div>
</div>