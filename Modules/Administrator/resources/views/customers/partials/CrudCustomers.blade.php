<div class="modal fade" id="modalCrudCustomers" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-lg modal-dialog modal-dialog-slideout" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="titleModal"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="post" data-parsley-validate id="formCrudCustomers">
                @csrf()
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="text" hidden name="action" id="CrudCustomersAction" />
                            <input type="text" hidden name="id" id="id" />
                            <div class="form-group">
                                <label for="name_customers">Name Customers* :</label>
                                <input type="text" id="name_customers" class="form-control" name="name_customers" required />
                            </div>
                            <div class="form-group">
                                <label for="code_customers">Code Customers* :</label>
                                <input type="text" id="code_customers" class="form-control" name="code_customers" required />
                            </div>

                            <div class="form-group">
                                <label for="email">Email * :</label>
                                <input type="email" id="email" class="form-control" name="email" data-parsley-trigger="change" required />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="phone">Phone * :</label>
                                <input type="text" id="phone" class="form-control" name="phone" required />
                            </div>
                            <div class="form-group">
                                <label for="address">Address * :</label>
                                <textarea type="text" id="address" class="form-control" name="address" data-parsley-trigger="change" required></textarea>
                            </div>
                        </div>
                    </div>

                    <hr />
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>Close</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-title"></button>
                    </div>
                    <div class="loader" style="display: none;">
                        <div class="col-md-12">
                            <div style="background-color: rgba(132, 122, 42, 0.63) !important;" class="alert alert-info mt-2" role="alert">
                                <span style="font-style: italic;">Please Wait Send Data . . .</span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div id="crudCustomersError"></div>
            <div id="crudCustomersAlertDelete"></div>
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
    $("#formCrudCustomers").parsley();
    $('#formCrudCustomers').submit(function(e) {
        e.preventDefault();
        var f = $(this);
        f.parsley().validate();

        if (f.parsley().isValid()) {
            var formData = new FormData($('#formCrudCustomers')[0]);
            var actions = $("#CrudCustomersAction").val();
            var url = '';
            if (actions == "create") {
                url = '{{ url("administrator/jsonCreateCustomers") }}';
            } else if (actions == "update") {
                url = '{{ url("administrator/jsonUpdateCustomers") }}';
            } else if (actions == "delete") {
                url = '{{ url("administrator/jsonDeleteCustomers") }}';
            }

            $.ajax({
                url: url,
                type: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                async: false,
                beforeSend: function() {
                    document.querySelector(".loader").style.display = "block";
                },
                complete: function() {
                    document.querySelector(".loader").style.display = "none";
                },
                success: function(data) {
                    console.log(data)
                    if (data.msg == "success") {
                        $('#modalCrudCustomers').modal('hide');
                        var act = $("#CrudCustomersAction").val();
                        act = act.toLowerCase();
                        ReloadBarang();
                        doSuccess('create', 'success ' + act + ' data', 'success')
                    } else {
                        var errMsg = '<div class="alert alert-warning mt-2" role="alert"><small><b> Error !</b><br/>' + data.msg + '</small></div>'
                        $('#crudCustomersError').html(errMsg);
                    }
                },
                error: function(xhr, desc, err) {
                    document.querySelector(".loader").style.display = "none";
                    var respText = "";
                    try {
                        respText = eval(xhr.responseText);
                    } catch {
                        respText = xhr.responseText;
                    }

                    respText = unescape(respText).replaceAll("_n_", "<br/>")

                    var errMsg = '<div class="alert alert-warning mt-2" role="alert"><small><b> Error ' + xhr.status + '!</b><br/>' + respText + '</small></div>'
                    $('#crudCustomersError').html(errMsg);
                },
            });
        } else {
            alert("form invalid");
        }
    })
</script>