<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tabbable-line">
                        <ul class="nav nav-tabs ">
                            <li class="<?php if ($tab == 'company') echo 'active' ?>">
                                <a href="<?php echo site_url('admin/settings?tab=company'); ?>">
                                    <?= lang('company_info') ?> </a>
                            </li>

                            <li class="<?php if ($tab == 'localization') echo 'active' ?>">
                                <a href="<?php echo site_url('admin/settings?tab=localization'); ?>">
                                    <?= lang('localization') ?> </a>
                            </li>
                            <li class="<?php if ($tab == 'invoice') echo 'active' ?>">
                                <a href="<?php echo site_url('admin/settings?tab=invoice'); ?>">
                                    <?= lang('invoice_settings') ?> </a>
                            </li>
                            <li class="<?php if ($tab == 'smtp_settings') echo 'active' ?>">
                                <a href="<?php echo site_url('admin/settings?tab=smtp_settings'); ?>">
                                    <?= lang('smtp_settings') ?> </a>
                            </li>
                            <li class="<?php if ($tab == 'email') echo 'active' ?>">
                                <a href="<?php echo site_url('admin/settings?tab=email'); ?>">
                                    <?= lang('email_address') ?> </a>
                            </li>
                        </ul>
                    </div>
                    <?php echo $tab_view; ?>
                </div>
            </div>
        </div>
    </div>
</div>
