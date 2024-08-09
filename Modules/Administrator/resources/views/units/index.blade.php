@extends('administrator::layouts.master')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Units</h2>
                <div class="nav navbar-right panel_toolbox">
                    <div class="input-group">
                        <input type="text" id="searching" class="form-control form-control-sm" placeholder="Search Name Unit..">
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
                    @if(CrudMenuPermission($MenuUrl, $user_id, "add"))
                    <button type="button" name="tloEnable" onclick="CrudUnits('create','*')" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus"></i> Create</button>
                    @endif
                    <button type="button" name="tloEnable" onclick="ReloadBarang()" class="btn btn-sm btn-outline-secondary"><i class="fa fa-refresh"></i> Refresh</button>
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
</script>
@include('administrator::units.partials.CrudUnits')
<script>
    $(document).ready(function() {

        $("#jqGridMain").jqGrid({
            url: "{{ url('administrator/jsonUnits') }}",
            datatype: "json",
            mtype: "GET",
            postData: {
                id: "1",
                "_token": "{{ csrf_token() }}",
                parent: "*"
            },
            colModel: [{
                label: 'ID',
                name: 'id',
                key: true,
                hidden: true,
            }, {
                label: 'Name Unit',
                name: 'name_unit',
                align: 'left',
                width: 50
            }, {
                label: 'Code Unit',
                name: 'code_unit',
                align: 'left',
                width: 40
            }, {
                label: 'Remarks',
                name: 'remarks',
                width: 90
            }, {
                label: 'User Id',
                name: 'id',
                align: 'CreatedBy',
                width: 30,
                align: 'center',

            }, {
                label: 'Created',
                name: 'CreatedAt',
                align: 'center',
                width: 50,
                formatter: "date",
                formatoptions: {
                    srcformat: "ISO8601Long",
                    newformat: "d M Y H:i:s"
                },
            }, {
                label: 'Status',
                name: 'status_unit',
                align: 'center',
                width: 35,
                formatter: function(cellvalue, options, rowObject) {
                    var status = rowObject.status_unit == 1 ? 'Active' : 'Inactive';
                    var badge = rowObject.status_unit == 1 ? 'badge-success' : 'badge-danger';
                    return `<span class="badge ${badge}">${status}</span>`;
                },
            }, {
                label: 'Action',
                name: 'id',
                align: 'center',
                width: 70,
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
            subGridRowExpanded: ChildUnits
        });

        function ChildUnits(subgrid_id, row_id) {
            var subgrid_table_id, pager_id;
            subgrid_table_id = subgrid_id + "_t";
            pager_id = "p_" + subgrid_table_id;
            $("#" + subgrid_id).html("<table id='" + subgrid_table_id + "' class='scroll'></table><div id='" + pager_id + "' class='scroll'></div>");
            $("#" + subgrid_table_id).jqGrid({
                url: "{{ url('administrator/jsonUnits') }}",
                mtype: "GET",
                datatype: "json",
                postData: {
                    id: row_id,
                    "_token": "{{ csrf_token() }}",
                    parent: row_id
                },
                page: 1,
                colModel: [{
                        label: "id",
                        name: "id",
                        hidden: true,
                        key: true
                    }, {
                        label: "Code",
                        name: "code_unit",
                        width: 40
                    }, {
                        label: "Name",
                        name: "name_unit",
                        width: 86
                    },
                    {
                        label: "Remarks",
                        name: "remarks",
                    }, {
                        label: 'Status',
                        name: 'status_unit',
                        align: 'center',
                        width: 45,
                        formatter: function(cellvalue, options, rowObject) {
                            var status = rowObject.status_unit == 1 ? 'Active' : 'Inactive';
                            var badge = rowObject.status_unit == 1 ? 'badge-success' : 'badge-danger';
                            return `<span class="badge ${badge}">${status}</span>`;
                        },
                    }, {
                        label: 'Action',
                        name: 'id',
                        align: 'center',
                        width: 70,
                        formatter: actionBarangFormatter
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
                loadonce: true,
                rownumbers: true,
                rownumWidth: 40,
                rowNum: 99999,
                width: 500,
                height: 50,
            });
        }


        function actionBarangFormatter(cellvalue, options, rowObject) {
            var btnid = options.rowId;
            var btn = "";
            <?php
            if (CrudMenuPermission($MenuUrl, $user_id, 'edit')) { ?>
                btn += `<button data-id="${btnid}" onclick="CrudUnits('update','${btnid}')"  class="btn btn-sm text-white btn-option badge-success"><i class="fa fa-pencil"></i></button>`;
            <?php } else { ?>
                btn += `<button disabled class="btn btn-sm text-white btn-option badge-success"><i class="fa fa-pencil"></i></button>`;
            <?php } ?>
            <?php if (CrudMenuPermission($MenuUrl, $user_id, 'delete')) { ?>
                btn += `<button  data-id="${btnid}" onclick="CrudUnits('delete','${btnid}')" class="btn btn-sm text-white btn-option badge-danger"><i class="fa fa-remove"></i></button>`;
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

    function CrudUnits(action, idx) {

        if (action == "create") {
            document.getElementById("formCrudUnits").reset();
            $("#formCrudUnits .form-control").prop("disabled", false);
            $(".btn-title").html('<i class="fa fa-save"></i> Create')
            $("#titleModal").html('Create Units')
            $('#modalCrudUnits').modal('show');
            $('#CrudUnitsError').html("");
            $("#CrudUnitsAction").val('create');
            $("#CrudUnitsAlertDelete").html('');
        } else if (action == "update") {
            document.getElementById("formCrudUnits").reset();
            $(".btn-title").html('<i class="fa fa-save"></i> Update')
            $("#titleModal").html('Update Units')
            $('#modalCrudUnits').modal('show');
            $('#CrudUnitsError').html("");
            $("#CrudUnitsAction").val('update')
            details(idx)
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            $("#CrudUnitsAlertDelete").html('');
        } else if (action == "delete") {
            document.getElementById("formCrudUnits").reset();
            $(".btn-title").html('<i class="fa fa-trash"></i> Delete')
            $("#titleModal").html('Delete Units')
            $('#modalCrudUnits').modal('show');
            $('#CrudUnitsError').html("");
            $("#CrudUnitsAction").val('delete')
            details(idx)
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            var errMsg = '<div class="col-md-12"><div class="alert alert-danger mt-2" role="alert"><span><b>Data Will Be Delete Permanently ,sure want delete ?</span></div></div>'
            $("#CrudUnitsAlertDelete").html(errMsg)
        }
    }

    function details(idx) {
        $.ajax({
            url: '{{ url("administrator/jsonDetailUnits") }}',
            type: 'POST',
            method: 'post',
            data: {
                id: idx,
                "_token": "{{ csrf_token() }}",
            },
            async: false,
            success: function(res) {
                var act = $("#CrudUnitsAction").val()
                $("#name_unit").val(res.name_unit)
                $("#code_unit").val(res.code_unit)
                $("#code_unit").val(res.code_unit)
                $("#unit_level").val(res.unit_level)
                $("#parent_id").val(res.parent_id).trigger('change')
                res.status_unit == 1 ? $('#status_unit').prop('checked', true) : $('#status_unit').prop('checked', false);
                $("#id").val(res.id)
                if (act == "delete") {
                    $("#formCrudUnits .form-control").prop("disabled", true);
                } else {
                    $("#formCrudUnits .form-control").prop("disabled", false);
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

        })
    }
</script>
@endsection