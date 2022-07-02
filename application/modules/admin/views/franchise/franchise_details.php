<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">        
        <?php echo message_box('success'); ?>
        <?php echo message_box('error'); ?>
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="<?php if ($tab == 'personal') echo 'active' ?>">
                        <a href="<?php echo site_url('admin/franchise/franchiseDetails?tab=personal/' . str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($franchise->id))); ?>"><?= lang('personal_details') ?></a>
                    </li>
                    <li class="<?php if ($tab == 'login') echo 'active' ?>">
                        <a href="<?php echo site_url('admin/franchise/franchiseDetails?tab=login/' . str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($franchise->id))); ?>"><?= lang('login') ?></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <?php echo $tab_view; ?>
                </div>
            </div>
        </div>
    </div>
</div>