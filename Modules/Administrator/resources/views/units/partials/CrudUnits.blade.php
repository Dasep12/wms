<div class="modal fade" id="modalCrudUnits" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class=" modal-dialog modal-dialog-slideout" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="titleModal"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="post" data-parsley-validate id="formCrudUnits">
                @csrf()
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="parent_id">Parent Unit* :</label>
                                <select name="parent_id" class="form-control" id="parent_id">
                                    <option value="*">*</option>
                                    <?php
                                    foreach ($unitParent as $units) { ?>
                                        <option value="{{ $units->id }}">{{ $units->name_unit }}</option>
                                    <?php  } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="unit_level">Level Unit* :</label>
                                <input type="number" value="1" readonly id="unit_level" class="form-control" name="unit_level" required />
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <input type="text" hidden name="action" id="CrudUnitsAction" />
                            <input type="text" hidden name="id" id="id" />
                            <div class="form-group">
                                <label for="name_unit">Name Unit* :</label>
                                <input type="text" id="name_unit" class="form-control" name="name_unit" required />
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="code_unit">Code Unit* :</label>
                                <input type="text" id="code_unit" class="form-control" name="code_unit" required />
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="code_unit">Remarks * :</label>
                                <textarea type="text" id="remarks" class="form-control" name="remarks"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="status_unit">Status Unit* :</label>
                                <input type="checkbox" checked id="status_unit" class="" name="status_unit" />
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

            <div id="CrudUnitsError"></div>
            <div id="CrudUnitsAlertDelete"></div>
        </div>
    </div>
</div>

<script>
    $("#parent_id").change(function() {
        if (this.value === "*") {
            $("#unit_level").val(1)
        } else {
            $("#unit_level").val(2)
        }
    })

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
    $("#formCrudUnits").parsley();
    $('#formCrudUnits').submit(function(e) {
        e.preventDefault();
        var f = $(this);
        f.parsley().validate();

        if (f.parsley().isValid()) {
            var formData = new FormData($('#formCrudUnits')[0]);
            var actions = $("#CrudUnitsAction").val();
            var url = '';
            if (actions == "create") {
                url = '{{ url("administrator/jsonCreateUnits") }}';
            } else if (actions == "update") {
                url = '{{ url("administrator/jsonUpdateUnits") }}';
            } else if (actions == "delete") {
                url = '{{ url("administrator/jsonDeleteUnits") }}';
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
                        $('#modalCrudUnits').modal('hide');
                        var act = $("#CrudUnitsAction").val();
                        act = act.toLowerCase();
                        ReloadBarang();
                        doSuccess('create', 'success ' + act + ' data', 'success')
                    } else {
                        var errMsg = '<div class="col-md-12"><div class="alert alert-warning mt-2" role="alert"><small><b> Error !</b><br/>' + data.msg + '</small></div></div>'
                        $('#CrudUnitsError').html(errMsg);
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
                    $('#CrudUnitsError').html(errMsg);
                },
            });
        } else {
            alert("form invalid");
        }
    })
</script>