<script src="<?php echo site_url('assets/js/ajax.js') ?>"></script>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <?php echo message_box('success'); ?>
            <?php echo message_box('error'); ?>
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Billing Tax</h5>
                    <div class="ibox-tools">
                        <a class="btn btn-primary" onclick="add()"><i class="fa fa-fw fa-plus"></i><?= lang('add_tax') ?></a>
                    </div>
                </div>
                <div class="ibox-content">                    
                    <div class="table-responsive">
                        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?= lang('tax_name') ?></th>
                                    <th><?= lang('tax_rate') ?></th>
                                    <th><?= lang('tax_type') ?></th>
                                    <th style="width:125px;"><?= lang('actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>

    var save_method; //for save method string
    var table;
    var list        = 'admin/settings/billing_tax_list';
    var saveRow     = 'admin/settings/add_billing_tax';
    var edit        = 'admin/settings/update_billing_tax';
    var deleteRow   = 'admin/settings/delete_billing_tax/';
    var saveSuccess = "<?php echo $this->message->success_msg() ?>" ;
    var deleteSuccess = "<?php echo $this->message->delete_msg() ?>" ;
    var deleteError = "<?php echo lang('record_has_been_used'); ?>" ;



    function edit_title(id)
    {

        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('admin/settings/edit_billing_tax/')?>/" + id,
            type: "GET",
            data : {'csrf_test_name' : getCookie('csrf_cookie_name')},
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.id);
                $('[name="name"]').val(data.tax);
                $('[name="rate"]').val(data.rate);
                $('[name="type"]').val(data.type);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('<?php lang('edit_tax');?>'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

</script>





<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= lang('tax') ?></h4>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3"><?= lang('tax') ?></label>
                            <div class="col-md-9">
                                <select class="form-control" name="name">
                                    <option value="GST">GST</option>
                                    <option value="IGST">IGST</option>
                                    <option value="CGST">CGST</option>
                                    <option value="SGST">SGST</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Rate</label>
                            <div class="col-md-9">
                                <input type="text" name="rate"  class="form-control">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3"><?= lang('tax_type') ?></label>
                            <div class="col-md-9">
                                <select class="form-control" name="type">
                                    <option value="1"><?= lang('percentage') ?> (%)</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                    </div>

                </form>
            </div>


            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary"><?= lang('save') ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?= lang('cancel') ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
