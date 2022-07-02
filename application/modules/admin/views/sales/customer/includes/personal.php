<div class="panel-body">
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
            <!-- View massage -->
            <?php echo message_box('success'); ?>
            <?php echo message_box('error'); ?>

            <div class="ibox">
                <?php echo form_open_multipart('admin/customer/save_customer_personal_info', $attribute = array('id' => 'CustomerForm')) ?>
                     <div id="msg"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?= lang('customer_name') ?><span class="required" aria-required="true">*</span></label>
                                                <input type="text" name="name" value="<?php if (!empty($customer->name)) echo $customer->name ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('phone_1') ?><span class="required" aria-required="true">*</span></label>
                                                <input type="text" name="phone_1" class="form-control" value="<?php if (!empty($customer->phone_1)) echo $customer->phone_1 ?>">
                                            </div>
                                        </div>                                     
                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('email') ?></label>
                                                <input type="text" name="email" class="form-control" value="<?php if (!empty($customer->email)) echo $customer->email ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?= lang('country') ?><span class="required" aria-required="true">*</span></label>
                                                <select title="Select Country" name="country" class="form-control" id="country-name">      
                                                    <option value="">Select Country</option>
                                                    <?php
                                                    foreach ($countries as $key => $value) {
                                                        echo '<option value="'.$value->id.'" '.($customer->country==$value->id?'selected="selected"':'').'>'.ucwords($value->name).'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('state') ?><span class="required" aria-required="true">*</span></label>
                                                <?php if(!empty($states)){ ?>
                                                <select title="Select State" name="state" class="form-control" id="state-name">
                                                    <option value="">Select State</option>
                                                    <?php
                                                    $StateCode=[];
                                                    foreach ($states as $key => $value) {
                                                        echo '<option value="'.$value->id.'" '.($customer->state==$value->id?'selected="selected"':'').'>'.ucwords($value->name).'</option>';
                                                        $StateCode[]=$value->id;
                                                    }
                                                    ?>
                                                </select>
                                                <?php }else{ ?>
                                                    <select title="Select State" name="state" class="form-control" id="state-name">      
                                                        <option value="">Select State</option>
                                                    </select>
                                                <?php } ?>
                                            </div>                                            
                                        </div>
                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('city') ?><span class="required" aria-required="true">*</span></label>
                                                    <?php if(!empty($cities)){ ?>
                                                    <select title="Select City" name="city" class="form-control" id="city-name">  
                                                        <option value="">Select City</option>
                                                        <?php
                                                        foreach ($cities as $key => $value) {
                                                            echo '<option value="'.$value->id.'" '.($customer->city==$value->id?'selected="selected"':'').' class="'.$value->state_id.'">'.ucwords($value->name).'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php }else{ ?>
                                                        <select title="Select City" name="city" class="form-control" id="city-name">      
                                                            <option value="">Select City</option>
                                                        </select>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="city citybox" style="display: none;">
                                                <div class="form-group row form-group-bottom">
                                                    <div class="col-lg-9">
                                                    <input name="other_city" placeholder="Enter City Name" class="form-control" value="" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- /.Start Date -->
                                            <div class="form-group form-group-bottom">
                                                <label><?= lang('zip_postal_code') ?></label>
                                                <input type="text" name="zipcode" class="form-control" value="<?php if (!empty($customer->zipcode)) echo $customer->zipcode ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?= lang('address') ?></label>
                                        <textarea class="form-control" name="address"><?php if (!empty($customer->address)) echo $customer->address ?></textarea>
                                    </div>
                                </div>
                            </div>
                <div class="box-footer">                    
                    <input type="hidden" name="id" value="<?php echo str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($customer->id)) ?>">
                    <input type="hidden" name="tab_view" value="personal">
                    <button class="btn btn-primary btn-sm" type="submit" value="Submit" id="saveCustomer"><?= lang('save') ?></button>
                </div>
                <?php echo $form->close(); ?>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</div>