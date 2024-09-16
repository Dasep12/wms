@extends('administrator::layouts.master')

@section('content')

<style>

</style>
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">


            <div class="x_title">
                <h2>Adjustment</h2>

                <div class="nav navbar-right panel_toolbox">
                    <div class="input-group">
                        <input type="text" id="searching" class="form-control form-control-sm" placeholder="Search No.Adjust ..">
                        <span class="input-group-btn">
                            <button onclick="search()" id="searchBtn" class="btn-filter btn btn-secondary btn-sm" type="button"><i class="fa fa-search"></i> Search</button>
                        </span>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="jqGridMain"></table>
                <div id="pager"></div>

                <hr>

                <div class="form-group">
                    @if(CrudMenuPermission($MenuUrl, $user_id, "add"))
                    <button type="button" name="tloEnable" onclick="CrudAdjustment('create','*')" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus"></i> Create</button>
                    @endif
                    <button type="button" name="tloEnable" onclick="ReloadgridAdjust()" class="btn btn-sm btn-outline-secondary"><i class="fa fa-refresh"></i> Refresh</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!--  -->
<script>
    $(document).on('show.bs.modal', '.modal', function() {
        const zIndex = 1040 + 10 * $('.modal:visible').length;
        $(this).css('z-index', zIndex);
        setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));
    });

    //  Prepare  Data Material Adjustment
    var dataMaterialAdjustment = [];

    function ReloadgridAdjust() {
        $("#jqGridMain").jqGrid('setGridParam', {
            datatype: 'json',
            mtype: 'GET',
            postData: {
                id: "",
                search: $("#searching").val()
            }
        }).trigger('reloadGrid');
    }

    function search() {
        ReloadgridAdjust()
        $("#searching").val("")
    }
    var input = document.getElementById("searching");
    input.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("searchBtn").click();
        }
    });
</script>
@include('administrator::adjustment.partials.CrudAdjustment')
@include('administrator::adjustment.partials.AddMaterial')
@include('administrator::adjustment.partials.FormAddMaterial')
<script>
    $(document).ready(function() {

        $("#jqGridMain").jqGrid({
            url: "{{ url('administrator/jsonAdjustment') }}",
            datatype: "json",
            mtype: "GET",
            postData: {
                "_token": "{{ csrf_token() }}",
            },
            colModel: [{
                    label: 'ID',
                    name: 'id',
                    key: true,
                    hidden: true,
                }, {
                    label: 'Action',
                    name: 'id',
                    align: 'center',
                    width: 50,
                    formatter: actionBarangFormatter
                }, {
                    label: 'Status',
                    name: 'status',
                    width: 40,
                    align: 'center',
                    formatter: function(cellvalue, options, rowObject) {
                        var badgeClass = cellvalue == "open" ? 'badge-success' : 'badge-danger';
                        return `<span style="font-size:10px !important;padding:5px !important;" class="badge ${badgeClass}" >${ cellvalue }</span>`
                    }
                }, {
                    label: 'Name Customers',
                    name: 'name_customers',
                    align: 'left',
                    width: 140,
                    hidden: true
                }, {
                    label: 'types',
                    name: 'types',
                    align: 'left',
                    width: 140,
                    hidden: true
                }, {
                    label: 'Customers',
                    name: 'code_customers',
                    align: 'center',
                    width: 70,
                }, {
                    label: 'customer_id',
                    name: 'customer_id',
                    align: 'center',
                    hidden: true
                }, {
                    label: 'No.Adjust',
                    name: 'no_surat_jalan',
                    align: 'center',
                    width: 120,
                },
                {
                    label: 'Remarks',
                    name: 'remarks',
                    align: 'left',
                },
                {
                    label: 'Date',
                    name: 'date_trans',
                    align: 'left',
                    width: 90,
                    formatter: "date",
                    formatoptions: {
                        srcformat: "ISO8601Long",
                        newformat: "d M Y H:i:s"
                    }
                }
            ],
            jsonReader: {
                repeatitems: false,
                root: function(obj) {
                    return obj.rows;
                },
                page: function(obj) {
                    return obj.page;
                },
                total: function(obj) {
                    return obj.total;
                },
                records: function(obj) {
                    return obj.records;
                }
            },
            viewrecords: true,
            rownumbers: true,
            rownumWidth: 30,
            autoresizeOnLoad: true,
            gridview: true,
            width: '100%',
            height: 350,
            rowNum: 10,
            rowList: [10, 30, 50],
            pager: "#pager",
            subGrid: true,
            subGridRowExpanded: loadDetailMaterial,
            loadComplete: function(data) {
                $("#jqGridMain").parent().find(".no-data").remove(); // Remove the message if there is data
                if (data.records == 0) {
                    $("#jqGridMain").parent().append("<div class='d-flex justify-content-center no-data'><h3 class='text-secondary'>data not found</h3></div>");
                }
                $(window).on('resize', function() {
                    var gridWidth = $('#jqGridMain').closest('.ui-jqgrid').parent().width();
                    $('#jqGridMain').jqGrid('setGridWidth', gridWidth);
                }).trigger('resize');
            },
        });

        function loadDetailMaterial(subgrid_id, row_id) {
            // Function to load subgrid data
            var subgrid_table_id = subgrid_id + "_t";
            $("#" + subgrid_id).html("<table id='" + subgrid_table_id + "' class='scroll'></table>");
            $("#" + subgrid_table_id).jqGrid({
                url: "{{ url('administrator/jsonDetailMaterial') }}",
                mtype: "GET",
                datatype: "json",
                postData: {
                    id: row_id,
                    "_token": "{{ csrf_token() }}",
                },
                page: 1,
                colModel: [{
                        label: "Material",
                        name: "name_material",
                        width: 150
                    }, {
                        label: "No Material",
                        name: "no_material",
                        width: 150
                    },
                    {
                        label: "Units",
                        name: "units",
                        width: 60,
                        align: 'center',
                    }, {
                        label: "Packaging",
                        name: "packaging",
                        width: 90,
                        align: 'center',
                    }, {
                        label: "Units",
                        name: "qtyUnits",
                        width: 90,
                        align: 'center',
                        formatter: 'currency',
                        formatoptions: {
                            prefix: '',
                            suffix: '',
                            thousandsSeparator: ','
                        },
                    }, {
                        label: "Packaging",
                        name: "qtyPackaging",
                        width: 90,
                        align: 'center',
                        formatter: 'currency',
                        formatoptions: {
                            prefix: '',
                            suffix: '',
                            thousandsSeparator: ','
                        },
                    }
                ],
                jsonReader: {
                    repeatitems: false,
                    root: function(obj) {
                        return obj.rows;
                    },
                    page: function(obj) {
                        return obj.page;
                    },
                    total: function(obj) {
                        return obj.total;
                    },
                    records: function(obj) {
                        return obj.records;
                    }
                },
                height: '100%',
                rowNum: 20,
                pager: "#" + subgrid_id + "_p"
            });
        }

        function actionBarangFormatter(cellvalue, options, rowObject) {
            var btnid = options.rowId;
            var lock = rowObject.status == "open" ? '' : "disabled";
            var btn = "";
            <?php
            if (CrudMenuPermission($MenuUrl, $user_id, 'edit')) { ?>
                btn += `<button ${lock} type="button" data-id="${btnid}" onclick="CrudAdjustment('update','${btnid}')"  class="btn btn-sm text-white btn-option tes badge-success"><i class="fa fa-pencil"></i></button><button ${lock} type="button" data-id="${btnid}" onclick="CrudAdjustment('putaway','${btnid}')" class="btn btn-sm text-white btn-option badge-primary"><i class="fa fa-recycle"></i></button>`;
            <?php } else { ?>
                btn += `<button disabled class="btn btn-sm text-white btn-option badge-success"><i class="fa fa-pencil"></i></button><button type="button" disabled class="btn btn-sm text-white btn-option badge-primary"><i class="fa fa-recycle"></i></button>`;
            <?php } ?>
            <?php if (CrudMenuPermission($MenuUrl, $user_id, 'delete')) { ?>
                btn += `<button ${lock} type="button" data-id="${btnid}" onclick="CrudAdjustment('delete','${btnid}')" class="btn btn-sm text-white btn-option badge-danger"><i class="fa fa-remove"></i></button>`;
            <?php } else { ?>
                btn += `<button disabled class="btn btn-sm text-white btn-option badge-danger"><i class="fa fa-remove"></i></button>`;
            <?php } ?>
            return btn;
        }




    })




    function CrudAdjustment(action, idx) {

        $("#ValidateField").html('');
        if (action == "create") {
            document.getElementById("formCrudAdjustment").reset();
            dataMaterialAdjustment = [];
            reloadgridAdjustmentList(dataMaterialAdjustment);
            $("#QtyStorageDeliveryMaterialField").attr("readonly", false)
            $("#QtyDeliveryMaterialField").attr("readonly", false)
            $("#formCrudAdjustment .form-control").prop("disabled", false);
            $(".btn-titless").html('<i class="fa fa-save"></i> Create')
            $("#titleModal").html('Create Adjustment')
            $('#modalCrudAdjustment').modal('show');
            $('#CrudAdjustmentError').html("");
            $("#CrudAdjustmentAction").val('create');
            $("#CrudAdjustmentAlertDelete").html('');
            $("#formCrudAdjustment .form-control").attr("readonly", false)
            $("#no_surat_jalan").attr("readonly", true);
            $(".btnResetField").attr("disabled", false);
        } else if (action == "update") {
            document.getElementById("formCrudAdjustment").reset();
            loadDetail(idx)
            loadMateriaList(idx)
            $(".btn-titless").html('<i class="fa fa-save"></i> Update')
            $("#titleModal").html('Update Inbound')
            $('#modalCrudAdjustment').modal('show');
            $('#CrudAdjustmentError').html("");
            $("#CrudAdjustmentAction").val('update')
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            $("#CrudAdjustmentAlertDelete").html('');
            $("#formCrudAdjustment .form-control").attr("readonly", false)
            $(".btnResetField").attr("disabled", false)
        } else if (action == "delete") {
            document.getElementById("formCrudAdjustment").reset();
            $(".btn-titless").html('<i class="fa fa-trash"></i> Delete')
            $("#titleModal").html('Delete Adjustment')
            $('#modalCrudAdjustment').modal('show');
            $('#CrudAdjustmentError').html("");
            $("#CrudAdjustmentAction").val('delete')
            $(".btnResetField").attr("disabled", true)
            $("#formCrudAdjustment .form-control").attr("readonly", true)

            loadDetail(idx)
            loadMateriaList(idx)
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            var errMsg = '<div class="col-md-12"><div class="alert alert-danger mt-2" role="alert"><span><b>Data Akan Di Hapus Secara Permanen, yakin lanjut hapus ?</span></div></div>'
            $("#CrudAdjustmentAlertDelete").html(errMsg)
        } else if (action == "putaway") {
            document.getElementById("formCrudAdjustment").reset();
            $(".btn-titless").html('<i class="fa fa-unsorted"></i> Adjust Stock')
            $("#titleModal").html('Putaway')
            $('#modalCrudAdjustment').modal('show');
            $('#CrudAdjustmentError').html("");
            $("#CrudAdjustmentAction").val('putaway')
            $(".btnResetField").attr("disabled", true)
            $("#formCrudAdjustment .form-control").attr("readonly", true)

            loadDetail(idx)
            loadMateriaList(idx)
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            var errMsg = '<div class="col-md-12"><div class="alert alert-warning mt-2" role="alert"><span><b>Mengirim Data Akan Merubah Jumlah Stock ,yakin data sudah benar ?</span></div></div>'
            $("#CrudAdjustmentAlertDelete").html(errMsg)
        }
    }


    function loadDetail(idx) {
        var Grid = $('#jqGridMain'),
            selRowId = idx,
            idMaterialField = Grid.jqGrid('getCell', selRowId, 'id'),
            customer_id = Grid.jqGrid('getCell', selRowId, 'customer_id'),
            no_reference = Grid.jqGrid('getCell', selRowId, 'no_reference'),
            ship_to = Grid.jqGrid('getCell', selRowId, 'ship_to'),
            type_adjust = Grid.jqGrid('getCell', selRowId, 'types'),
            no_truck = Grid.jqGrid('getCell', selRowId, 'no_truck'),
            driver = Grid.jqGrid('getCell', selRowId, 'driver'),
            date_trans = Grid.jqGrid('getCell', selRowId, 'date_trans'),
            date_transs = Grid.jqGrid('getCell', selRowId, 'date_transs'),
            remarks = Grid.jqGrid('getCell', selRowId, 'remarks'),
            no_surat_jalan = Grid.jqGrid('getCell', selRowId, 'no_surat_jalan');
        $("#customer_id").val(customer_id).trigger('change');
        $("#type_adjust").val(type_adjust).trigger('change');
        $("#ship_to").val(ship_to);
        $("#driver").val(driver);
        $("#no_truck").val(no_truck);
        $("#no_surat_jalan").val(no_surat_jalan);
        $("#no_reference").val(no_reference);
        $("#date_trans").val(date_trans);
        $("#remarks").val(remarks);
        $("#date_transs").val(date_transs);
        $("#id").val(idx)


    }

    function loadMateriaList(row_id) {
        $.ajax({
            url: "{{ url('administrator/jsonDetailListMaterialEdit') }}",
            method: "GET",
            data: {
                id: row_id,
                "_token": "{{ csrf_token() }}",
            },
            beforeSend: function() {
                dataMaterialAdjustment = [];
            },
            success: function(res) {
                dataMaterialAdjustment = [];
                for (let i = 0; i < res.length; i++) {
                    var datas = {
                        'id': res[i].material_id,
                        'no_material': res[i].no_material,
                        'name_material': res[i].name_material,
                        'uniqid': res[i].uniqid,
                        'unit': res[i].unit,
                        'units': res[i].units,
                        'packaging': res[i].packaging,
                        'qtyUnit': res[i].qtyUnit,
                        'qtyUnits': res[i].qtyUnits,
                        'qtyPackaging': res[i].qtyPackaging,
                        'detail_id': res[i].id,
                        'StockqtyUnit': res[i].begin_stock_unit,
                        'StockqtyUnits': res[i].begin_stock_units,
                        'StockqtyPackaging': res[i].begin_stock_packaging,
                        'details_unit': res[i].details_unit,
                    }
                    dataMaterialAdjustment.push(datas);
                }
                reloadgridAdjustmentList(dataMaterialAdjustment);
            }
        })
    }
</script>
@endsection