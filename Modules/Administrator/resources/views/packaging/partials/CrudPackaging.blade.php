<div class="modal fade" id="modalCrudPackaging" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class=" modal-dialog modal-dialog-slideout" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="titleModal"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="post" data-parsley-validate id="formCrudPackaging">
                @csrf()
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="text" hidden name="action" id="CrudPackagingAction" />
                            <input type="text" hidden name="id" id="id" />
                            <div class="form-group">
                                <label for="name_packaging">Name Packaging* :</label>
                                <input type="text" id="name_packaging" class="form-control" name="name_packaging" required />
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="status_packaging">Status * :</label>
                                <input type="checkbox" name="status_packaging" id="status_packaging" checked>
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

            <div id="CrudPackagingError"></div>
            <div id="CrudPackagingAlertDelete"></div>
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
    $("#formCrudPackaging").parsley();
    $('#formCrudPackaging').submit(function(e) {
        e.preventDefault();
        var f = $(this);
        f.parsley().validate();

        if (f.parsley().isValid()) {
            var formData = new FormData($('#formCrudPackaging')[0]);
            var actions = $("#CrudPackagingAction").val();
            var url = '';
            if (actions == "create") {
                url = '{{ url("administrator/jsonCreatePackaging") }}';
            } else if (actions == "update") {
                url = '{{ url("administrator/jsonUpdatePackaging") }}';
            } else if (actions == "delete") {
                url = '{{ url("administrator/jsonDeletePackaging") }}';
            }

            $.ajax({
                url: url,
                type: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                async: false,
                success: function(data) {
                    if (data.msg == "success") {
                        $('#modalCrudPackaging').modal('hide');
                        var act = $("#CrudPackagingAction").val();
                        act = act.toLowerCase();
                        ReloadBarang();
                        doSuccess('create', 'success ' + act + ' data', 'success')
                    } else {
                        var errMsg = '<div class="col-md-12"><div class="alert alert-warning mt-2" role="alert"><small><b> Error !</b><br/>' + data.msg + '</small></div></div>'
                        $('#CrudPackagingError').html(errMsg);
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
                    $('#CrudPackagingError').html(errMsg);
                },
            });
        } else {
            alert("form invalid");
        }
    })
</script>