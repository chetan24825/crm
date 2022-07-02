<script src="<?php echo site_url('assets/js/ajax.js') ?>"></script>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5><?= lang('company_list') ?></h5>
                <div class="ibox-tools">
                    <div class="input-group input-group-sm">
                        <a class="btn btn-primary btn-sm btn-flat" onclick="add()"><i class="fa fa-fw fa-plus"></i><?= lang('add_company') ?></a>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <div id="msg"></div>
                    <table id="table" class="table table-striped table-bordered table-hover dataTables-example" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><?= lang('company') ?></th>
                                <th><?= lang('description') ?></th>
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


<script>
    var save_method; //for save method string
    var table;
    var list = 'admin/company/company_list';
    var saveRow = 'admin/company/add_company';
    var edit = 'admin/company/update_company';
    var deleteRow = 'admin/company/delete_company/';
    var saveSuccess = "<?php echo $this->message->success_msg() ?>";
    var deleteSuccess = "<?php echo $this->message->delete_msg() ?>";
    var deleteError = "<?php echo lang('record_has_been_used'); ?>";



    function edit_title(id) {

        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('admin/company/edit_company/') ?>/" + id,
            type: "GET",
            data: {
                'csrf_test_name': getCookie('csrf_cookie_name')
            },
            dataType: "JSON",
            success: function(data) {
                $('[name="id"]').val(data.id);
                $('[name="company"]').val(data.company);
                $('[name="bankinfo"]').val(data.bankinfo);
                $('[name="paytm"]').val(data.paytm);
                $('[name="googlepay"]').val(data.googlepay);
                $('[name="address"]').val(data.company_address);
                $('[name="gst"]').val(data.company_gst);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Company'); // Set title to Bootstrap modal title

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
</script>





<!-- Bootstrap modal -->
<div class="modal inmodal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= lang('add_company') ?></h4>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id" />
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3"><?= lang('company') ?></label>
                            <div class="col-md-9">
                                <input name="company" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Bank Info</label>
                            <div class="col-md-9">
                                <textarea name="bankinfo" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Paytm</label>
                            <div class="col-md-9">
                                <input name="paytm" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Google Pay</label>
                            <div class="col-md-9">
                                <input name="googlepay" class="form-control" type="text">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3"><?= lang('address') ?></label>
                            <div class="col-md-9">
                                <textarea name="address" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3"><?= lang('gst') ?></label>
                            <div class="col-md-9">
                                <input name="gst" class="form-control" type="text">
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