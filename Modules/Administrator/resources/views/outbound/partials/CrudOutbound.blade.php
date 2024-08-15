<div class="modal fade" id="modalCrudOutbound" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-xl modal-dialog modal-dialog-slideout" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="titleModal"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form method="post" class="" data-parsley-validate id="formCrudOutbound">
                @csrf()
                <input type="text" hidden name="action" id="CrudOutboundAction" />
                <input type="text" hidden name="id" id="id" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3 pr-1 pl-1">
                            <div class="form-group">
                                <label for="" class="">Customers :</label>
                                <select required name="customer_id" class="form-control" id="customer_id">
                                    <option value="">* Select Customers </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 pr-1 pl-1">
                            <div class="form-group">
                                <label for="no_surat_jalan" class="">No.SJ :</label>
                                <input type="text" required name="no_surat_jalan" id="no_surat_jalan" class="form-control" placeholder="*No.Surat Jalan">
                            </div>
                        </div>

                        <div class="col-md-3 pr-1 pl-1">
                            <div class="form-group">
                                <label for="no_reference" class="">DN Number : </label>
                                <input type="text" name="no_reference" id="no_reference" class="form-control" placeholder="*DN Number">
                            </div>
                        </div>

                        <div class="col-md-2 pr-1 pl-1">
                            <div class="form-group">
                                <label for="date_trans" class="">Date :</label>
                                <input type="text" required name="date_trans" id="date_trans" class="form-control" />
                            </div>
                        </div>

                        <div class="col-md-2 pr-1 pl-1">
                            <div class="form-group">
                                <label for="no_truck" class="">No.Truck :</label>
                                <input type="text" required name="no_truck" id="no_truck" class="form-control" placeholder="*Nopol Truck">
                            </div>
                        </div>

                        <div class="col-md-2 pr-1 pl-1">
                            <div class="form-group">
                                <label for="driver" class="">Driver :</label>
                                <input type="text" required name="driver" id="driver" class="form-control" placeholder="*Name Drivers">
                            </div>
                        </div>

                        <div class="col-md-3 pr-1 pl-1">
                            <div class="form-group">
                                <label for="" class="">Ship To :</label>
                                <input type="text" required name="ship_to" id="ship_to" placeholder="*Address" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12 pr-1 pl-1">
                            <table id="gridOutboundList"></table>
                            <div id="pagerGridOutboundList"></div>
                        </div>

                        <div class="col-md-12 pr-1 pl-1" id="errorFieldToSearchMaterial">
                        </div>

                    </div>

                    <hr />
                    <div class="modal-footer">
                        <div class="ml-3" style="position:absolute; left:0 !important">
                            <div class="row">
                                <div class="col">
                                    <!-- data-toggle="modal" data-target="#modalFormAddMaterial"  -->
                                    <button onclick="AddNewMaterialModal()" type="button" class="btn btn-sm btn-outline-secondary btnResetField"><i class="fa fa-plus"></i> Add New Material</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-title btn-titless"></button>
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

            <div id="ValidateField"></div>

            <div id="CrudOutboundError">

            </div>
            <div id="CrudOutboundAlertDelete"></div>
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
    $("#formCrudOutbound").parsley();


    $('#date_trans').datetimepicker({
        format: 'YYYY-MM-DD',
    });

    // List material outbound
    $("#gridOutboundList").jqGrid({
        datatype: "local",
        data: [],
        colModel: [{
                name: 'id',
                label: 'id',
                hidden: true,
                key: true,
            },
            {
                label: 'Material',
                name: 'name_material',
                width: 170,
            },
            {
                label: 'No Material',
                name: 'no_material',
                width: 155,
            },
            {
                label: 'Unique No',
                name: 'uniqid',
                width: 155,
            },
            {
                name: 'unit',
                label: 'Unit',
                align: 'center',
                width: 90
            },
            {
                name: 'units',
                label: 'Units',
                align: 'center',
                width: 90
            }, {
                name: 'packaging',
                label: 'Packaging',
                align: 'center',
                width: 90
            }, {
                name: 'qtyUnit',
                label: 'Qty Unit',
                align: 'center',
                width: 90
            }, {
                name: 'qtyUnits',
                label: 'Qty Units',
                align: 'center',
                width: 90
            }, {
                name: 'qtyPackaging',
                label: 'Qty Packaging',
                align: 'center',
                width: 90
            }, {
                name: 'StockqtyUnit',
                label: 'Stock Qty Unit',
                align: 'center',
                width: 90,
                hidden: true,
            }, {
                name: 'StockqtyUnits',
                label: 'Stock Qty Units',
                align: 'center',
                width: 90,
                hidden: true,
            }, {
                name: 'StockqtyPackaging',
                label: 'Stock Qty Packaging',
                align: 'center',
                width: 90,
                hidden: true,
            }, {
                name: 'details_unit',
                label: 'details_unit',
                align: 'center',
                width: 90,
                hidden: true,
            },
            {
                label: 'ID DETAIL',
                name: 'detail_id',
                align: 'center',
                hidden: true
            },
            {
                name: 'id',
                label: 'Action',
                align: 'center',
                width: 80,
                formatter: actionListMaterial
            }
        ],
        pager: "#pagerGridOutboundList",
        viewrecords: true,
        width: '100%',
        rowNum: 15,
        height: 'auto',
        shrinkToFit: false,
        autowidth: true,
    });

    jQuery("#gridOutboundList").jqGrid('setGroupHeaders', {
        useColSpanStyle: true,
        groupHeaders: [{
            startColumnName: 'unit',
            numberOfColumns: 3,
            titleText: 'Detail'
        }, {
            startColumnName: 'qtyUnit',
            numberOfColumns: 3,
            titleText: 'Outbound'
        }]
    });

    $("#gridOutboundList").navGrid("#pagerGridOutboundList", {
        add: false,
        edit: false,
        del: false,
        search: false,
        refresh: true
    });



    function actionListMaterial(values, options, rowObject) {

        var btnid = rowObject.id;
        var act = $("#CrudOutboundAction").val();
        var lock = act == "delete" || act == "putaway" ? 'disabled' : '';
        var btn = `<button ${lock} type="button" data-id="${btnid}" onclick="CrudListOutbound('update','${btnid}')"  class="btn btn-sm text-white btn-option badge-success btnActionMaterial"><i class="fa fa-pencil"></i></button>`;
        btn += `<button ${lock} type="button" data-id="${btnid}" onclick="CrudListOutbound('delete','${btnid}')" class="btn btn-sm text-white btn-option badge-danger btnActionMaterial"><i class="fa fa-remove"></i></button>`;
        return btn;
    }


    function reloadgridOutboundList(data) {
        // Clear existing data
        $("#gridOutboundList").jqGrid('clearGridData', true);
        $("#gridOutboundList").jqGrid('setGridParam', {
            data: data
        });
        // Refresh the grid
        $("#gridOutboundList").trigger('reloadGrid');
    }


    // Adjust grid size when modal is shown
    $('#modalCrudOutbound').on('shown.bs.modal', function() {
        $("#gridOutboundList").jqGrid('setGridWidth', $(".modal-dialog").width() * 0.98); // Adjust the width as needed
    });


    function CrudListOutbound(action, idx) {
        var Grid = $('#gridOutboundList'),
            selRowId = idx,
            idMaterialField = Grid.jqGrid('getCell', selRowId, 'id'),
            name_material = Grid.jqGrid('getCell', selRowId, 'name_material'),
            no_material = Grid.jqGrid('getCell', selRowId, 'no_material'),
            uniqid = Grid.jqGrid('getCell', selRowId, 'uniqid'),
            unit = Grid.jqGrid('getCell', selRowId, 'unit'),
            units = Grid.jqGrid('getCell', selRowId, 'units'),
            details_unit = Grid.jqGrid('getCell', selRowId, 'details_unit'),
            packaging = Grid.jqGrid('getCell', selRowId, 'packaging'),
            qtyUnit = Grid.jqGrid('getCell', selRowId, 'qtyUnit'),
            qtyUnits = Grid.jqGrid('getCell', selRowId, 'qtyUnits'),
            qtyPackaging = Grid.jqGrid('getCell', selRowId, 'qtyPackaging'),
            StockqtyUnit = Grid.jqGrid('getCell', selRowId, 'StockqtyUnit'),
            StockqtyUnits = Grid.jqGrid('getCell', selRowId, 'StockqtyUnits'),
            StockqtyPackaging = Grid.jqGrid('getCell', selRowId, 'StockqtyPackaging');


        // STOCK FIELD
        $(".QtyUnitOutbound").val(StockqtyUnit)
        $(".QtyUnitsOutbound").val(StockqtyUnits)
        $(".QtyPackagingOutbound").val(StockqtyPackaging)

        // DETAIL MATERIAL
        $("#nameMaterialField").val(name_material)
        $("#noMaterialField").val(no_material)
        $("#UniqueIdMaterialField").val(uniqid)
        $("#UnitMaterialField").val(unit)
        $("#UnitsMaterialField").val(units)
        $("#PackagingMaterialField").val(packaging)

        // STOCK OUTBOUND REQ
        $("#QtyUnitOutbound").val(qtyUnit)
        $("#QtyUnitsOutbound").val(qtyUnits)
        $("#QtyPackagingOutbound").val(qtyPackaging)
        $("#idMaterialField").val(idMaterialField)
        $("#details_unit").val(details_unit);


        // LABEL MATERIAL 
        $("#qtyStorageLabel").html(packaging)
        $("#qtyUnitLabel").html(unit)
        $("#qtySatuanLabel").html(units)
        $(".qtyUnitLabel").html(unit)
        $(".qtyStorageLabel").html(packaging)
        $(".qtySatuanLabel").html(units)
        if (action == "create") {
            $(".btn-formAddMaterial").html(`<i class="fa fa-check"></i> Select`);
            $(".btnFindMaterial").attr("disabled", false)
            $("#QtyUnitInbound").attr("readonly", false)
            $("#QtyUnitsInbound").attr("readonly", false)
            $("#QtyPackagingInbound").attr("readonly", false)
        } else if (action == "delete") {
            $(".btnFindMaterial").attr("disabled", true)
            $("#actionListMaterialField").val("delete");
            $("#QtyUnitsInbound").attr("readonly", true)
            $("#QtyUnitInbound").attr("readonly", true)
            $("#QtyPackagingInbound").attr("readonly", true)
            $('#modalFormAddMaterial').modal('show');
            $(".btn-formAddMaterial").html(`<i class="fa fa-trash"></i> Delete`);
        } else if (action == "update" || action == "putaway") {
            $("#actionListMaterialField").val("update");
            $(".btnFindMaterial").attr("disabled", false)
            $(".btn-formAddMaterial").html(`<i class="fa fa-check"></i> Update`);
            $('#modalFormAddMaterial').modal('show');
            $("#QtyUnitInbound").attr("readonly", false)
            $("#QtyUnitsInbound").attr("readonly", false)
            $("#QtyPackagingInbound").attr("readonly", false)
        }
    }


    function removeMaterialWithId(arr, id) {
        const objWithIdIndex = arr.findIndex((obj) => obj.id === id);
        if (objWithIdIndex > -1) {
            arr.splice(objWithIdIndex, 1);
        }
        return arr;
    }


    function AddNewMaterialModal() {
        $("#ValidateField").html('');
        document.getElementById("materialFormField").reset();
        var errorCount = 0
        // Validate all fields when input field empty
        $("#formCrudOutbound .form-control").each(function() {
            var $this = $(this);
            if ($this.val().trim() === "") {
                errorCount++;
            }
        });
        $(".btn-formAddMaterial").html(`<i class="fa fa-check"></i> Select`);
        $("#jqGridListMaterial").jqGrid('setGridWidth', $(".modal-dialog").width() * 0.67); //

        $("#details_unit").attr("placeholder", "Detail Unit");
        if (errorCount <= 0) {
            $('#modalFormAddMaterial').modal('show');
        } else {
            $('#modalFormAddMaterial').modal('hide');
            var msg = `<div class="col-md-12">
                    <div class="alert alert-danger" role="alert">
                        <span class="font-italic">Data Customers,DN Number  , Driver , Truck lainnya tidak di izinkan kosong </span>
                    </div>
                </div>`
            $("#ValidateField").html(msg);
            errorCount = 0;
        }

        $(".formAddMaterial").html()
        $(".btnFindMaterial").attr("disabled", false)
        $("#QtyUnitsInbound").attr("readonly", false)
        $("#QtyUnitInbound").attr("readonly", false)
        $("#QtyPackagingInbound").attr("readonly", false)
        $("#actionListMaterialField").val("create");
        $("#qtyPerUnitLabel").html('')
        $("#qtyUnitLabel").html('')
        $("#qtyStorageLabel").html('')
        $(".qtyUnitLabel").html('')
        $(".qtyStorageLabel").html('')
        $(".qtySatuanLabel").html('')
        $("#QtyStorageLabelDeliveryMaterialField").val('')
        $("#SatuanDeliveryMaterialField").val('')
        $("#qtySatuanLabel").html('')


    }

    // Fetch Customers
    function GetlistCustomers(query) {
        $.ajax({
            url: '{{ url("administrator/jsonListUnitsByCustomers") }}',
            data: {
                q: query
            },
            success: function(data) {
                var $select = $('#customer_id');
                $select.empty();
                $select.append('<option value="">Please Select Customers</option>');
                $.each(data, function(index, option) {
                    $select.append('<option value="' + option.id + '">' + option.name_customers + '</option>');
                });
            }
        });
    }

    GetlistCustomers("");

    $("#customer_id").change(function(e) {
        $.ajax({
            url: "{{ url('administrator/generateDNOutbound') }}",
            method: "POST",
            data: {
                customers_id: $("#customer_id").val(),
                "_token": "{{ csrf_token() }}"
            },
            success: function(res) {
                $("#no_surat_jalan").val(res);
            }
        })
    })

    $('#formCrudOutbound').submit(function(e) {
        e.preventDefault();
        var f = $(this);
        f.parsley().validate();

        if (f.parsley().isValid()) {
            var formData = new FormData($('#formCrudOutbound')[0]);
            var actions = $("#CrudOutboundAction").val();
            var url = '';
            if (actions == "create") {
                url = '{{ url("administrator/jsonCreateOutbound") }}';
            } else if (actions == "update") {
                url = '{{ url("administrator/jsonUpdateOutbound") }}';
            } else if (actions == "delete") {
                url = '{{ url("administrator/jsonDeleteOutbound") }}';
            } else if (actions == "putaway") {
                url = '{{ url("administrator/jsonPutawayOutbound") }}';
            }

            var data = {
                '_token': "{{ csrf_token() }}",
                'action': $("input[name=action]").val(),
                'id': $("input[name=id]").val(),
                'customer_id': $("#customer_id").val(),
                'no_surat_jalan': $("input[name=no_surat_jalan]").val(),
                'no_reference': $("input[name=no_reference]").val(),
                'date_trans': $("input[name=date_trans]").val(),
                'no_truck': $("input[name=no_truck]").val(),
                'driver': $("input[name=driver]").val(),
                'ship_to': $("input[name=ship_to]").val(),
                'dataMaterial': JSON.stringify(dataMaterialOutbound)
            }

            $.ajax({
                url: url,
                method: "POST",
                type: 'POST',
                data: data,
                beforeSend: function() {
                    document.querySelector(".loader").style.display = "block";
                },
                complete: function() {
                    document.querySelector(".loader").style.display = "none";
                },
                success: function(data) {
                    if (data.msg == "success") {
                        dataMaterialOutbound = [];
                        $('#modalCrudOutbound').modal('hide');
                        var act = $("#CrudOutboundAction").val();
                        act = act.toLowerCase();
                        ReloadBarang();
                        doSuccess('create', 'success ' + act + ' data', 'success')
                    } else {
                        var errMsg = '<div class="col-md-12"><div class="alert alert-warning mt-2" role="alert"><small><b> Error !</b><br/>' + data.msg + '</small></div></div>'
                        $('#CrudOutboundError').html(errMsg);
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