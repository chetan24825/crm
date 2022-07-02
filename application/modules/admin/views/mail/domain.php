<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>



<div class="row">
    <div class="col-md-12">

        <form id="addPayment" action="<?php echo site_url('admin/mail/sendDomainEmail') ?>" method="post" onsubmit="return get_Cookie('csrf_cookie_name')" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="token">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= lang('compose_new_message') ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <input id="toEmail" class="form-control" placeholder="To:" name="to" value="<?php if (!empty($customer->email)) echo $customer->email ?>" onfocusout="toEmailValidator()">
                        <p class="help-block" style="color: red" id="el"></p>
                        <p class="help-block"><?= lang('use_comma(,)_for_multiple_email') ?> </p>
                    </div>
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Subject:" name="subject" value="<?php echo $domain->domain_name; ?>">
                </div>
                <div class="form-group">
                    <textarea id="compose-textarea" name="msg" class="form-control" style="height: 300px">
                Dear <?php echo $customer->name ?>,</br>
                Your <?php echo $domain->domain_name; ?> domain is going to expire soon.</br>
            </br>
            </br>
            </br>
                Regards
                </br>
                <?php echo get_option('company_name'); ?>
            </textarea>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn bg-olive btn-flat" id="btn" ><?= lang('send') ?></button>
                    </div>
                    <a type="reset" class="btn btn-default" href="<?php echo site_url('admin/mail') ?>">
                        <i class="fa fa-times"></i> <?= lang('discard') ?></a>
                </div>
                <!-- /.box-footer -->
            </div>
            <?php echo form_close() ?>


            <!-- /. box -->
    </div>

</div>



<script>
    $(function() {
        //Add text editor
        $("#compose-textarea").wysihtml5();
    });
    updateList = function() {
        var input = document.getElementById('file');
        var output = document.getElementById('fileList');

        output.innerHTML = '<ul>';
        for (var i = 0; i < input.files.length; ++i) {
            output.innerHTML += '<li>' + input.files.item(i).name + '</li>';
        }
        output.innerHTML += '</ul>';
    }

    function get_Cookie(name) {
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        $('#token').val(cookieValue);
    }

    function toEmailValidator(trim = true) {
        var emailList = $('#toEmail').val();
        var email_split = emailList.split(',');
        var valid = true;
        for (var n = 0; n < email_split.length; n++) {
            var email_info = trim ? email_split[n].trim() : email_split[n];
            var validRegExp = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
            if (email_info.search(validRegExp) === -1) {
                valid = false;
                break;
            }
        }
        if (!valid) {
            document.getElementById("el").innerHTML = "<?= lang('email_addresses_are_not_valid.') ?><br/>";
            $('#btn').prop('disabled', true);
        } else {
            document.getElementById("el").innerHTML = "";
            $('#btn').prop('disabled', false);
        }
    }
</script>