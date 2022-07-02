<div class="panel-body">
    <div class="col-md-7 col-sm-12 col-xs-12">
        <?php echo form_open_multipart('admin/franchise/save_franchise_personal_info', $attribute = array('id' => 'FranchiseForm')) ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label><?= lang('first_name') ?><span class="required" aria-required="true">*</span></label>
                    <input type="text" name="first_name" value="<?php echo $franchise->first_name ?>" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><?= lang('last_name') ?><span class="required" aria-required="true">*</span></label>
                    <input type="text" name="last_name" value="<?php echo $franchise->last_name ?>" class="form-control">
                </div>
            </div>
            <?php $contact_details = json_decode($franchise->contact_details); ?>
            <div class="col-md-12">
                <div class="form-group">
                    <label><?= lang('address_street') ?><span class="required">*</span></label>
                    <input type="text" name="address" class="form-control" value="<?php if (!empty($contact_details->address)) {
                                                                            echo $contact_details->address;
                                                                        } ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><?= lang('city') ?> <span class="required">*</span></label>
                    <input type="text" name="city" class="form-control" value="<?php if (!empty($contact_details->city)) {
                                                                                echo $contact_details->city;
                                                                            } ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><?= lang('state_province') ?><span class="required">*</span></label>
                    <input type="text" name="state" class="form-control" value="<?php if (!empty($contact_details->state)) {
                                                                                echo $contact_details->state;
                                                                            } ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><?= lang('zip_postal_code') ?><span class="required">*</span></label>
                    <input type="text" name="postal" class="form-control" value="<?php if (!empty($contact_details->postal)) {
                                                                                    echo $contact_details->postal;
                                                                                } ?>">
                </div>
                <hr />
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><?= lang('country') ?><span class="required" aria-required="true">*</span></label>
                    <select class="form-control" name="country">
                        <option value=""><?= lang('please_select') ?>..</option>
                        <?php foreach ($countries as $item) { ?>
                            <option value="<?php echo $item->country ?>" <?php if (!empty($franchise->country)) echo $franchise->country == $item->country ? 'selected' : ''  ?>><?php echo $item->country ?></option>
                        <?php } ?>

                    </select>
                </div>
                <hr />
            </div>
            <hr />
            <div class="col-md-6">
                <div class="form-group">
                    <label><?= lang('work_telephone') ?></label>
                    <input type="text" name="work_telephone" class="form-control" value="<?php if (!empty($contact_details->work_telephone)) {
                                                                                            echo $contact_details->work_telephone;
                                                                                        } ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><?= lang('work_email') ?></label>
                    <input type="text" name="work_email" class="form-control" value="<?php if (!empty($contact_details->work_email)) {
                                                                                        echo $contact_details->work_email;
                                                                                    } ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><?= lang('mobile') ?></label>
                    <input type="text" name="mobile" class="form-control" value="<?php if (!empty($contact_details->mobile)) {
                                                                                    echo $contact_details->mobile;
                                                                                } ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><?= lang('other_email') ?></label>
                    <input type="text" name="other_email" class="form-control" value="<?php if (!empty($contact_details->other_email)) {
                                                                                        echo $contact_details->other_email;
                                                                                    } ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><?= lang('joined_date') ?><span class="required">*</span></label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="datepicker3" name="joined_date"  value="<?php if($franchise->joined_date != '0000-00-00')echo $franchise->joined_date ?>" data-date-format="yyyy/mm/dd">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar-o"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <input type="hidden" name="id" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($franchise->id)) ?>">
         <input type="hidden" name="tab_view" value="personal">
        <div class="form-group row">
            <div class="col-sm-4">
                <button id="saveFranchise" type="submit" class="btn bg-olive btn-flat">Save</button>
            </div>
        </div>
        <?php echo $form->close(); ?>
    </div>
</div>