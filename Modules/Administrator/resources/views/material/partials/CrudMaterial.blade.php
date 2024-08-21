<div class="modal fade" id="modalCrudMaterial" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-lg modal-dialog modal-dialog-slideout" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="titleModal"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="post" data-parsley-validate id="formCrudMaterial">
                @csrf()
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="text" hidden name="action" id="CrudMaterialAction" />
                            <input type="text" hidden name="id" id="id" />
                            <div class="form-group">

                                <label for="customers_id">Name Customers* :</label>
                                <select style="width: 100%;" name="customers_id" class="form-control custom-select" required data-parsley-allselected id="customers_id">
                                    <option value="">Select Customers</option>
                                </select>
                                <div id="customers_id-errors" class="parsley-errors-list"></div>
                            </div>
                            <div class="form-group">
                                <label for="name_material">Name Material* :</label>
                                <input type="text" id="name_material" class="form-control" name="name_material" required />
                                <div id="name_material-errors" class="parsley-errors-list"></div>
                            </div>

                            <div class="form-group">
                                <label for="no_material">Number Material * :</label>
                                <input type="text" id="no_material" class="form-control" name="no_material" required />
                                <div id="no_material-errors"></div>
                            </div>

                            <div class="form-group">
                                <label for="location_id">Location * :</label>
                                <select style="width: 100%;" name="location_id" class="form-control custom-select" required data-parsley-allselected id="location_id">
                                    <option value="">Select Location</option>
                                </select>
                                <div id="location_id-errors"></div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="parentUnitId">Units * :</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select style="width: 100%;" name="parentUnitId" class="form-control custom-select" required data-parsley-allselected id="parentUnitId">
                                            <option value="">Select Units</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select style="width: 100%;" name="unit_id" class="form-control custom-select" required data-parsley-allselected id="unit_id">
                                            <option value="">Select Units</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="unit_id-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="uniqueId">Unique Number * :</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" id="uniqueId" class="form-control" name="uniqueId" required />
                                        <div id="uniqueId-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="packaging_id">Packaging * :</label>
                                <select style="width: 100%;" name="packaging_id" class="form-control custom-select" required data-parsley-allselected id="packaging_id">
                                    <option value="">Select Units</option>
                                </select>
                                <div id="packaging_id-errors"></div>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" value="1" id="status_material" name="status_material" class="checkeds" checked="checked" /> <label for="status_material"> Status *</label>
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

            <div id="CrudMaterialError"></div>
            <div id="CrudMaterialAlertDelete"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        // $('.select2-single').select2({
        //     dropdownParent: $('#modalCrudMaterial'),
        //     ajax: {
        //         url: '{{ url("administrator/jsonForListCustomer") }}',
        //         dataType: 'json',
        //         data: (params) => {
        //             let query = {
        //                 search: params.term,
        //                 page: params.page || 1,
        //             };
        //             return query;
        //         },
        //         processResults: data => {
        //             return {
        //                 results: data.data.map((user) => {
        //                     return {
        //                         text: user.name_customers.toLowerCase().toUpperCase(),
        //                         id: user.id
        //                     };
        //                 }),
        //                 pagination: {
        //                     more: data.current_page < data.last_page,
        //                 },
        //             };
        //         },
        //     }
        // });


        // Fetch Customers
        function GetlistCustomers(query) {
            $.ajax({
                url: '{{ url("administrator/jsonForListCustomer") }}',
                data: {
                    q: query
                },
                success: function(data) {
                    var $select = $('#customers_id');
                    $select.empty();
                    $select.append('<option value="">Please Select Customers</option>');
                    $.each(data, function(index, option) {
                        $select.append('<option value="' + option.id + '">' + option.name_customers + '</option>');
                    });
                }
            });
        }

        // Fetch Units
        function GetlistUnit(query) {
            $.ajax({
                url: '{{ url("administrator/jsonForListUnit") }}',
                data: {
                    parent: query
                },
                success: function(data) {
                    var $select = $('#parentUnitId');
                    $select.empty();
                    $select.append('<option value="">Please Select Units</option>');
                    $.each(data, function(index, option) {
                        $select.append('<option value="' + option.id + '">' + option.name_unit + '</option>');
                    });
                }
            });
        }

        // Fetch Packaging
        function GetlistPackingstorage(query) {
            $.ajax({
                url: '{{ url("administrator/jsonForListPackaging") }}',
                data: {
                    parent: query
                },
                success: function(data) {
                    var $select = $('#packaging_id');
                    $select.empty();
                    $select.append('<option value="">Please Select Packaging</option>');
                    $.each(data, function(index, option) {
                        $select.append('<option value="' + option.id + '">' + option.name_packaging + '</option>');
                    });
                }
            });
        }

        // Fetch Location
        function GetlistLocation(query) {
            $.ajax({
                url: '{{ url("administrator/jsonForListLocation") }}',
                data: {
                    id: query
                },
                success: function(data) {
                    var $select = $('#location_id');
                    $select.empty();
                    $select.append('<option value="">Please Select Location</option>');
                    $.each(data, function(index, option) {
                        $select.append('<option value="' + option.id + '">' + option.location + '</option>');
                    });
                }
            });
        }




        GetlistCustomers('')
        GetlistUnit('*')
        GetlistPackingstorage('')
        GetlistLocation('')
        $("#formCrudMaterial").parsley({
            errorPlacement: function(error, ParsleyField) {
                var fieldId = ParsleyField.$element.attr('id') + '-errors';
                $('#' + fieldId).append(error);
            },
            errorsContainer: function(ParsleyField) {
                var fieldId = ParsleyField.$element.attr('id') + '-errors';
                return $('#' + fieldId);
            }
        });

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

        // submit form data to server
        $('#formCrudMaterial').submit(function(e) {
            e.preventDefault();
            var f = $(this);
            f.parsley().validate();

            if (f.parsley().isValid()) {
                var formData = new FormData($('#formCrudMaterial')[0]);
                var actions = $("#CrudMaterialAction").val();
                var url = '';
                if (actions == "create") {
                    url = '{{ url("administrator/jsonCreateMaterial") }}';
                } else if (actions == "update") {
                    url = '{{ url("administrator/jsonUpdateMaterial") }}';
                } else if (actions == "delete") {
                    url = '{{ url("administrator/jsonDeleteMaterial") }}';
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    async: false,
                    success: function(data) {
                        // console.log(data)
                        if (data.msg == "success") {
                            $('#modalCrudMaterial').modal('hide');
                            var act = $("#CrudMaterialAction").val();
                            act = act.toLowerCase();
                            ReloadBarang();
                            doSuccess('create', 'success ' + act + ' data', 'success')
                        } else {
                            var errMsg = '<div class="col-md-12"><div class="alert alert-warning mt-2" role="alert"><small><b> Error !</b><br/>' + data.msg + '</small></div></div>'
                            $('#CrudMaterialError').html(errMsg);
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
                        $('#crudCustomersError').html(errMsg);
                    },
                });
            } else {
                alert("form invalid");
            }
        })
    })
</script>