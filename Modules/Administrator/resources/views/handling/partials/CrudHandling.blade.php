<div class="modal fade" id="modalCrudHandling" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-lg modal-dialog modal-dialog-slideout" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="titleModal"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="post" data-parsley-validate id="formCrudHandling">
                @csrf()
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="text" hidden name="action" id="CrudHandlingAction" />
                            <input type="text" hidden name="id" id="id" />
                            <div class="form-group">
                                <label for="nameHandling">Name Handling* :</label>
                                <input type="text" id="nameHandling" class="form-control" name="nameHandling" required />
                            </div>
                            <div class="form-group">
                                <input type="checkbox" value="1" id="status_handling" name="status_handling" class=" " checked="checked" /> <label for="status_handling"> Status *</label>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="price">Price Handling* :</label>
                                <input type="text" onkeypress="return isNumberKey(event)" id="price" class="form-control" name="price" required />
                            </div>

                            <div class="form-group">
                                <label for="remarks"> Remarks *</label>
                                <textarea class="form-control" id="remarks" name="remarks"></textarea>
                            </div>


                        </div>
                    </div>

                    <hr />
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-title"></button>
                    </div>
                </div>
            </form>

            <div id="CrudHandlingError"></div>
            <div id="CrudHandlingAlertDelete"></div>
        </div>
    </div>
</div>

<script>
    function doSuccess(act, msg, theme) {
        const myNotification = window.createNotification({
            // options here
            displayCloseButton: true,
            theme: theme //success error , information , success
        });

        myNotification({
            title: 'Information',
            message: msg
        });
    }
    $("#formCrudHandling").parsley();
    $('#formCrudHandling').submit(function(e) {
        e.preventDefault();
        var f = $(this);
        f.parsley().validate();

        if (f.parsley().isValid()) {
            var formData = new FormData($('#formCrudHandling')[0]);
            var actions = $("#CrudHandlingAction").val();
            var url = '';
            if (actions == "create") {
                url = '{{ url("administrator/jsonCreateHandling") }}';
            } else if (actions == "update") {
                url = '{{ url("administrator/jsonUpdateHandling") }}';
            } else if (actions == "delete") {
                url = '{{ url("administrator/jsonDeleteHandling") }}';
            }

            $.ajax({
                url: url,
                type: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                async: false,
                success: function(data) {
                    console.log(data)
                    if (data.msg == "success") {
                        $('#modalCrudHandling').modal('hide');
                        var act = $("#CrudHandlingAction").val();
                        act = act.toLowerCase();
                        ReloadBarang();
                        doSuccess('create', 'success ' + act + ' data', 'success')
                    } else {
                        var errMsg = '<div class="col-md-12"><div class="alert alert-warning mt-2" role="alert"><small><b> Error !</b><br/>' + data.msg + '</small></div></div>'
                        $('#CrudHandlingError').html(errMsg);
                    }
                },
                error: function(xhr, desc, err) {
                    var respText = "";
                    try {
                        respText = eval(xhr.responseText);
                    } catch {
                        respText = xhr.responseText;
                    }

                    respText = unescape(respText).replaceAll("_n_", "<br/>")

                    var errMsg = '<div class="col-md-12"><div class="alert alert-warning mt-2" role="alert"><small><b> Error ' + xhr.status + '!</b><br/>' + respText + '</small></div></div>'
                    $('#CrudHandlingError').html(errMsg);
                },
            });
        } else {
            alert("form invalid");
        }
    })
</script>