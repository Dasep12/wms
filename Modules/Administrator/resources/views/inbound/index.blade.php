@extends('administrator::layouts.master')

@section('content')

<style>

</style>
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">


            <div class="x_title">
                <h2>Inbound</h2>

                <div class="nav navbar-right panel_toolbox">
                    <div class="input-group">
                        <input type="text" id="searching" class="form-control form-control-sm" placeholder="Search DN..">
                        <span class="input-group-btn">
                            <button onclick="search()" class="btn-filter btn btn-secondary btn-sm" type="button"><i class="fa fa-search"></i> Search</button>
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
                    @if(CrudMenuPermission($MenuUrl, 1, "add"))
                    <button type="button" name="tloEnable" onclick="CrudInbound('create','*')" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus"></i> Create</button>
                    @endif
                    <button type="button" name="tloEnable" onclick="ReloadBarang()" class="btn btn-sm btn-outline-secondary"><i class="fa fa-refresh"></i> Refresh</button>
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

    //  Prepare  Data Material Inbound
    var dataMaterialInbound = [];

    function ReloadBarang() {
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
        ReloadBarang()
        $("#searching").val("")
    }
</script>
@include('administrator::inbound.partials.CrudInbound')
@include('administrator::inbound.partials.AddMaterial')
@include('administrator::inbound.partials.FormAddMaterial')
<script>
    $(document).ready(function() {

        $("#jqGridMain").jqGrid({
            url: "{{ url('administrator/jsonInbound') }}",
            datatype: "json",
            mtype: "GET",
            postData: {
                id: "1",
                "_token": "{{ csrf_token() }}",
            },
            colModel: [{
                    label: 'ID',
                    name: 'id',
                    key: true,
                    hidden: true,
                }, {
                    label: 'Putaway',
                    name: 'id',
                    width: 30,
                    align: 'center',
                    formatter: function(cellvalue, options, rowObject) {
                        var lock = rowObject.status == "open" ? '' : "disabled";
                        var btnid = rowObject.id;
                        return `<button ${lock} type="button" data-id="${btnid}" onclick="CrudInbound('putaway','${btnid}')" class="btn btn-sm text-white btn-option badge-primary"><i class="fa fa-upload"></i></button>`
                    }
                }, {
                    label: 'Action',
                    name: 'id',
                    align: 'center',
                    width: 40,
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
                    label: 'DN',
                    name: 'no_surat_jalan',
                    align: 'center',
                    width: 50,
                }, {
                    label: 'No Ref',
                    name: 'no_reference',
                    align: 'center',
                    width: 60,
                    hidden: true
                }, {
                    label: 'Driver',
                    name: 'driver',
                    align: 'center',
                    width: 60,
                }, {
                    label: 'Truck',
                    name: 'no_truck',
                    align: 'center',
                    width: 60,
                },
                {
                    label: 'Ship To',
                    name: 'ship_to',
                    align: 'left',
                    hidden: false
                }, {
                    label: 'no_truck',
                    name: 'no_truck',
                    align: 'center',
                    hidden: true
                }, {
                    label: 'driver',
                    name: 'driver',
                    align: 'left',
                    hidden: true
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
            width: 780,
            height: 350,
            rowNum: 10,
            rowList: [10, 30, 50],
            pager: "#pager",
            subGrid: true,

            subGridRowExpanded: loadDetailMaterial
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
                    }, {
                        label: "Packaging",
                        name: "qtyPackaging",
                        width: 90,
                        align: 'center',
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
            if (CrudMenuPermission($MenuUrl, 1, 'edit')) { ?>
                btn += `<button ${ lock } type="button" data-id="${btnid}" onclick="CrudInbound('update','${btnid}')"  class="btn btn-sm text-white btn-option tes badge-success"><i class="fa fa-pencil"></i></button>`;
            <?php } else { ?>
                btn += `<button disabled class="btn btn-sm text-white btn-option badge-success"><i class="fa fa-pencil"></i></button>`;
            <?php } ?>
            <?php if (CrudMenuPermission($MenuUrl, 1, 'delete')) { ?>
                btn += `<button ${ lock } type="button" data-id="${btnid}" onclick="CrudInbound('delete','${btnid}')" class="btn btn-sm text-white btn-option badge-danger"><i class="fa fa-remove"></i></button>`;
            <?php } else { ?>
                btn += `<button disabled class="btn btn-sm text-white btn-option badge-danger"><i class="fa fa-remove"></i></button>`;
            <?php } ?>
            return btn;
        }


        $(window).on('resize', function() {
            var gridWidth = $('#jqGridMain').closest('.ui-jqgrid').parent().width();
            $('#jqGridMain').jqGrid('setGridWidth', gridWidth);
        }).trigger('resize');

    })







    function CrudInbound(action, idx) {

        $("#ValidateField").html('');
        if (action == "create") {
            document.getElementById("formCrudInbound").reset();
            dataMaterialInbound = [];
            reloadgridInboundList(dataMaterialInbound);
            $("#QtyStorageDeliveryMaterialField").attr("readonly", false)
            $("#QtyDeliveryMaterialField").attr("readonly", false)
            $("#formCrudInbound .form-control").prop("disabled", false);
            $(".btn-titless").html('<i class="fa fa-save"></i> Create')
            $("#titleModal").html('Create Inbound')
            $('#modalCrudInbound').modal('show');
            $('#CrudInboundError').html("");
            $("#CrudInboundAction").val('create');
            $("#CrudInboundAlertDelete").html('');
            $("#formCrudInbound .form-control").attr("readonly", false)
            $(".btnResetField").attr("disabled", false)
        } else if (action == "update") {
            document.getElementById("formCrudInbound").reset();
            loadDetail(idx)
            loadMateriaList(idx)
            $(".btn-titless").html('<i class="fa fa-save"></i> Update')
            $("#titleModal").html('Update Inbound')
            $('#modalCrudInbound').modal('show');
            $('#CrudInboundError').html("");
            $("#CrudInboundAction").val('update')
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            $("#CrudInboundAlertDelete").html('');
            $("#formCrudInbound .form-control").attr("readonly", false)
            $(".btnResetField").attr("disabled", false)
        } else if (action == "delete") {
            document.getElementById("formCrudInbound").reset();
            $(".btn-titless").html('<i class="fa fa-trash"></i> Delete')
            $("#titleModal").html('Delete Inbound')
            $('#modalCrudInbound').modal('show');
            $('#CrudInboundError').html("");
            $("#CrudInboundAction").val('delete')
            $(".btnResetField").attr("disabled", true)
            $("#formCrudInbound .form-control").attr("readonly", true)

            loadDetail(idx)
            loadMateriaList(idx)
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            var errMsg = '<div class="col-md-12"><div class="alert alert-danger mt-2" role="alert"><span><b>Data Akan Di Hapus Secara Permanen, yakin lanjut hapus ?</span></div></div>'
            $("#CrudInboundAlertDelete").html(errMsg)
        } else if (action == "putaway") {
            document.getElementById("formCrudInbound").reset();
            $(".btn-titless").html('<i class="fa fa-upload"></i> Add To Stock')
            $("#titleModal").html('Putaway')
            $('#modalCrudInbound').modal('show');
            $('#CrudInboundError').html("");
            $("#CrudInboundAction").val('putaway')
            $(".btnResetField").attr("disabled", true)
            $("#formCrudInbound .form-control").attr("readonly", true)

            loadDetail(idx)
            loadMateriaList(idx)
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            var errMsg = '<div class="col-md-12"><div class="alert alert-warning mt-2" role="alert"><span><b>Data Akan Di Tambahkan ke Stock ,yakin data sudah benar ?</span></div></div>'
            $("#CrudInboundAlertDelete").html(errMsg)
        }
    }


    function loadDetail(idx) {
        var Grid = $('#jqGridMain'),
            selRowId = idx,
            idMaterialField = Grid.jqGrid('getCell', selRowId, 'id'),
            customer_id = Grid.jqGrid('getCell', selRowId, 'customer_id'),
            no_reference = Grid.jqGrid('getCell', selRowId, 'no_reference'),
            ship_to = Grid.jqGrid('getCell', selRowId, 'ship_to'),
            no_truck = Grid.jqGrid('getCell', selRowId, 'no_truck'),
            driver = Grid.jqGrid('getCell', selRowId, 'driver'),
            date_trans = Grid.jqGrid('getCell', selRowId, 'date_trans'),
            no_surat_jalan = Grid.jqGrid('getCell', selRowId, 'no_surat_jalan');
        $("#customer_id").val(customer_id).trigger('change');
        $("#ship_to").val(ship_to);
        $("#driver").val(driver);
        $("#no_truck").val(no_truck);
        $("#no_surat_jalan").val(no_surat_jalan);
        // $("#no_reference").val(no_reference);
        $("#date_trans").val(date_trans);
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
                dataMaterialInbound = [];
            },
            success: function(res) {
                dataMaterialInbound = [];
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
                    }
                    dataMaterialInbound.push(datas);
                }
                reloadgridInboundList(dataMaterialInbound);
            }
        })
    }
</script>
@endsection