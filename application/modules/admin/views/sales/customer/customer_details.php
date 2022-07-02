<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">        
        <div class="col-lg-12">
        <?php echo message_box('success'); ?>
            <?php echo message_box('error'); ?>
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="<?php if ($tab == 'personal') echo 'active' ?>">
                        <a href="<?php echo site_url('admin/customer/customerDetails?tab=personal/' .$customer->id); ?>"><?= lang('personal_details') ?></a>
                    </li>
                    <li class="<?php if ($tab == 'login') echo 'active' ?>">
                        <a href="<?php echo site_url('admin/customer/customerDetails?tab=login/' .$customer->id); ?>"><?= lang('login') ?></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <?php echo $tab_view; ?>
                </div>
            </div>
        </div>
    </div>
</div>