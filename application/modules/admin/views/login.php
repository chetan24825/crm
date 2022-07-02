<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>font-awesome/css/font-awesome.css" rel="stylesheet">


</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <p><?= lang('sign_in') ?></p>
            <?php echo $form->open(); ?>
            <?php echo $form->messages(); ?>
                <div class="form-group">
                    <input tabindex="1" class="form-control input-lg" name="email" type="text" size="30" maxlength="100" title="Email" placeholder="User" value="">
                </div>
                <div class="form-group">
                    <input tabindex="1" class="form-control input-lg" name="password" type="password" size="30" maxlength="100" title="Password" placeholder="password" value="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b"><?= lang('log_in') ?></button>
                <a class="reset" tabindex="4" href="<?php echo base_url('admin/auth/forgot_password') ?>"><small><?= lang('forgot_password') ?> ?</small></a>
            <?php echo $form->close(); ?>
        </div>
    </div>
</body>
</html>