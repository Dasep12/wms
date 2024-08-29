@extends('administrator::layouts.master')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Warehouse </h2>
                <div class="nav navbar-right panel_toolbox">
                    <div class="input-group">
                        <input type="text" id="searching" class="form-control form-control-sm" placeholder="Search Name Warehouse..">
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
                    @if(CrudMenuPermission($MenuUrl, session()->get("user_id"), "add"))
                    <button type="button" name="tloEnable" onclick="CrudWarehouse('create','*')" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus"></i> Create</button>
                    @endif
                    <button type="button" name="tloEnable" onclick="ReloadBarang()" class="btn btn-sm btn-outline-secondary"><i class="fa fa-refresh"></i> Refresh</button>
                    <!-- <button type="button" name="tloEnable" onclick="Export()" class="btn btn-sm btn-outline-secondary"><i class="fa fa-file-pdf-o"></i> Export</button> -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<script>
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

    var input = document.getElementById("searching");
    input.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("searchBtn").click();
        }
    });
</script>
@include('administrator::warehouse.partials.CrudWarehouse')

<script>
    $(document).ready(function() {
        $("#jqGridMain").jqGrid({
            url: "{{ url('administrator/jsonWarehouse') }}",
            datatype: "json",
            mtype: "GET",
            postData: {
                id: "",
                "_token": "{{ csrf_token() }}",
            },
            colModel: [{
                label: 'ID',
                name: 'id',
                key: true,
                hidden: true,
            }, {
                label: 'Warehouse',
                name: 'NameWarehouse',
                align: 'left'
            }, {
                label: 'Area',
                name: 'Area',
                align: 'left'
            }, {
                label: 'Address',
                name: 'Address',
                align: 'left'
            }, {
                label: 'Status ',
                name: 'status_warehouse',
                align: 'center',
                formatter: function(cellvalue, options, rowObject) {
                    var status = rowObject.status_warehouse == 1 ? 'Active' : 'Inactive';
                    var badge = rowObject.status_warehouse == 1 ? 'badge-success' : 'badge-danger';
                    return `<span class="badge ${badge}">${status}</span>`;
                },
            }, {
                label: 'Date',
                name: 'created_at',
                align: 'left',
                formatter: "date",
                formatoptions: {
                    srcformat: "ISO8601Long",
                    newformat: "d M Y H:i:s"
                }
            }, {
                label: 'Action',
                name: 'action',
                align: 'center',
                // width: 70,
                formatter: actionBarangFormatter
            }],
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
            loadonce: false,
            viewrecords: true,
            rownumbers: true,
            rownumWidth: 30,
            autoresizeOnLoad: true,
            gridview: true,
            width: '100%',
            height: 350,
            rowNum: 20,
            rowList: [10, 30, 50],
            pager: "#pager",
            loadComplete: function(data) {
                $("#jqGridMain").parent().find(".no-data").remove(); // Remove the message if there is data
                if (data.records === 0) {
                    $("#jqGridMain").parent().append("<div class='d-flex justify-content-center no-data'><h3 class='text-secondary'>data not found</h3></div>");
                }

                $(window).on('resize', function() {
                    var gridWidth = $('#jqGridMain').closest('.ui-jqgrid').parent().width();
                    $('#jqGridMain').jqGrid('setGridWidth', gridWidth);
                }).trigger('resize');
            },
        });



        function actionBarangFormatter(cellvalue, options, rowObject) {
            var btnid = options.rowId;
            var btn = "";
            <?php
            if (CrudMenuPermission($MenuUrl, $user_id, 'edit')) { ?>
                btn += `<button data-id="${btnid}" onclick="CrudWarehouse('update','${btnid}')"  class="btn btn-sm text-white btn-option badge-success"><i class="fa fa-pencil"></i></button>`;
            <?php } else { ?>
                btn += `<button disabled class="btn btn-sm text-white btn-option badge-success"><i class="fa fa-pencil"></i></button>`;
            <?php } ?>
            <?php if (CrudMenuPermission($MenuUrl, $user_id, 'delete')) { ?>
                btn += `<button  data-id="${btnid}" onclick="CrudWarehouse('delete','${btnid}')" class="btn btn-sm text-white btn-option badge-danger"><i class="fa fa-remove"></i></button>`;
            <?php } else { ?>
                btn += `<button disabled class="btn btn-sm text-white btn-option badge-danger"><i class="fa fa-remove"></i></button>`;
            <?php } ?>
            return btn;
        }



    })



    function Export() {
        options = {
            title: 'Warehouse',
            orientation: 'portrait',
            pageSize: 'A4',
            description: null,
            onBeforeExport: null,
            download: 'download',
            includeLabels: true,
            includeGroupHeader: true,
            includeFooter: true,
            includeHeader: true,
            fileName: "jqGridExport.pdf",
            mimetype: "application/pdf",
            loadIndicator: true,
            treeindent: "-"
        }

        // Temporarily enable loadonce and reload grid
        $("#jqGridMain").jqGrid("setGridParam", {
            loadonce: true
        }).trigger("reloadGrid");
        $("#jqGridMain").jqGrid("hideCol", "action")
        $("#jqGridMain").jqGrid("hideCol", "status_warehouse")
        $("#jqGridMain").jqGrid("exportToPdf", options);
        $("#jqGridMain").jqGrid("showCol", "action")
        $("#jqGridMain").jqGrid("showCol", "status_warehouse");
        // Restore original loadonce state
        $("#jqGridMain").jqGrid("setGridParam", {
            loadonce: false
        }).trigger("reloadGrid");
    }



    function CrudWarehouse(action, idx) {

        if (action == "create") {
            document.getElementById("formCrudWarehouse").reset();
            $("#formCrudWarehouse .form-control").prop("disabled", false);
            $(".btn-title").html('<i class="fa fa-save"></i> Create')
            $("#titleModal").html('Create Units')
            $('#modalCrudWarehouse').modal('show');
            $('#CrudWarehouseError').html("");
            $("#CrudWarehouseAction").val('create');
            $("#CrudWarehouseAlertDelete").html('');
        } else if (action == "update") {
            document.getElementById("formCrudWarehouse").reset();
            $(".btn-title").html('<i class="fa fa-save"></i> Update')
            $("#titleModal").html('Update Units')
            $('#modalCrudWarehouse').modal('show');
            $('#CrudWarehouseError').html("");
            $("#CrudWarehouseAction").val('update')
            details(idx)
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            $("#CrudWarehouseAlertDelete").html('');
        } else if (action == "delete") {
            document.getElementById("formCrudWarehouse").reset();
            $(".btn-title").html('<i class="fa fa-trash"></i> Delete')
            $("#titleModal").html('Delete Units')
            $('#modalCrudWarehouse').modal('show');
            $('#CrudWarehouseError').html("");
            $("#CrudWarehouseAction").val('delete')
            details(idx)
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            var errMsg = '<div class="col-md-12"><div class="alert alert-danger mt-2" role="alert"><span><b>Data Will Be Delete Permanently ,sure want delete ?</span></div></div>'
            $("#CrudWarehouseAlertDelete").html(errMsg)
        }
    }

    function details(idx) {
        $.ajax({
            url: '{{ url("administrator/jsonDetailWarehouse") }}',
            type: 'POST',
            method: 'post',
            data: {
                id: idx,
                "_token": "{{ csrf_token() }}",
            },
            async: false,
            success: function(res) {
                var act = $("#CrudWarehouseAction").val()
                $("#NameWarehouse").val(res.NameWarehouse)
                $("#Address").val(res.Address)
                $("#Area").val(res.Area)
                res.status_warehouse == 1 ? $('#status_warehouse').prop('checked', true) : $('#status_warehouse').prop('checked', false);
                $("#id").val(res.id)
                if (act == "delete") {
                    $("#formCrudWarehouse .form-control").prop("disabled", true);
                } else {
                    $("#formCrudWarehouse .form-control").prop("disabled", false);
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
                $('#CrudWarehouseError').html(errMsg);
            },

        })
    }
</script>
@endsection