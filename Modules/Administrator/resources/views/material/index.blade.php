@extends('administrator::layouts.master')

@section('content')


<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Material</h2>
                <div class="nav navbar-right panel_toolbox">
                    <div class="input-group">
                        <input type="text" id="searching" class="form-control form-control-sm" placeholder="Search Name Material..">
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
                    <button type="button" name="tloEnable" onclick="CrudMaterial('create','*')" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus"></i> Create</button>
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
@include('administrator::material.partials.CrudMaterial')
<script>
    $(document).ready(function() {

        $("#jqGridMain").jqGrid({
            url: "{{ url('administrator/jsonMaterial') }}",
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
                label: 'Customers',
                name: 'code_customers',
                align: 'center',
                width: 110
            }, {
                label: 'Name Material',
                name: 'name_material',
                align: 'left',
                width: 190
            }, {
                label: 'Material Number',
                name: 'no_material',
                align: 'left',
                width: 100
            }, {
                label: 'Unique No',
                name: 'uniqueId',
                align: 'center',
                width: 65
            }, {
                label: 'Unit',
                name: 'unit',
                align: 'center',
                width: 90
            }, {
                label: 'Units',
                name: 'satuan',
                align: 'center',
                width: 90
            }, {
                label: 'Packaging',
                name: 'name_packaging',
                align: 'center',
                width: 90
            }, {
                label: 'Status',
                name: 'status_material',
                align: 'center',
                width: 55,
                formatter: function(cellvalue, options, rowObject) {
                    var status = rowObject.status_material == 1 ? 'Active' : 'Inactive';
                    var badge = rowObject.status_material == 1 ? 'badge-success' : 'badge-danger';
                    return `<span class="badge ${badge}">${status}</span>`;
                },
            }, {
                label: 'Date',
                name: 'created_at',
                align: 'center',
                formatter: "date",
                formatoptions: {
                    srcformat: "ISO8601Long",
                    newformat: "d M Y H:i:s"
                },
                width: 120,
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
            width: '100%',
            rowNum: 15,
            pager: "#pager",
            height: 350,
            autoresizeOnLoad: true,
            autowidth: true,
            shrinkToFit: false,
            fromServer: true,
            loadComplete: function() {
                $(this).jqGrid('setGridWidth', $("#jqGridMain").closest(".ui-jqgrid").parent().width());
            }
        });

        jQuery("#jqGridMain").jqGrid('setGroupHeaders', {
            useColSpanStyle: true,
            groupHeaders: [{
                startColumnName: 'unit',
                numberOfColumns: 3,
                titleText: 'Detail'
            }]
        });



        function actionBarangFormatter(cellvalue, options, rowObject) {
            var btnid = options.rowId;
            var btn = `<button data-id="${btnid}" onclick="CrudMaterial('update','${btnid}')"  class="btn btn-sm text-white btn-option badge-success"><i class="fa fa-pencil"></i></button>`;
            btn += `<a  data-id="${btnid}" onclick="CrudMaterial('delete','${btnid}')" class="btn btn-sm text-white btn-option badge-danger"><i class="fa fa-remove"></i></a>`;
            return btn;
        }

        $(window).on('resize', function() {
            var gridWidth = $('#jqGridMain').closest('.ui-jqgrid').parent().width();
            $('#jqGridMain').jqGrid('setGridWidth', gridWidth);
        }).trigger('resize');
    })

    function CrudMaterial(action, idx) {

        if (action == "create") {
            document.getElementById("formCrudMaterial").reset();
            $("select[name=unit_id]").empty();
            $("#formCrudMaterial .form-control,#formCrudMaterial .checkeds").prop("disabled", false);
            $(".btn-title").html('<i class="fa fa-save"></i> Create')
            $("#titleModal").html('Create Material')
            $('#modalCrudMaterial').modal('show');
            $('#CrudMaterialError').html("");
            $("#CrudMaterialAction").val('create');
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            $("#CrudMaterialAlertDelete").html('');
        } else if (action == "update") {
            document.getElementById("formCrudMaterial").reset();
            $(".btn-title").html('<i class="fa fa-save"></i> Update')
            $("#titleModal").html('Update Material')
            $('#modalCrudMaterial').modal('show');
            $('#CrudMaterialError').html("");
            $("#CrudMaterialAction").val('update')
            details(idx)
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            $("#CrudMaterialAlertDelete").html('');
        } else if (action == "delete") {
            document.getElementById("formCrudMaterial").reset();
            $(".btn-title").html('<i class="fa fa-trash"></i> Delete')
            $("#titleModal").html('Delete Material')
            $('#modalCrudMaterial').modal('show');
            $('#CrudMaterialError').html("");
            $("#CrudMaterialAction").val('delete')
            details(idx)
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            var errMsg = '<div class="col-md-12"><div class="alert alert-danger mt-2" role="alert"><span><b>Data Will Be Delete Permanently ,sure want delete ?</span></div></div>'
            $("#CrudMaterialAlertDelete").html(errMsg)
        }
    }




    $("#parentUnitId").change(function() {
        loadChildUnits('*')
    })

    function loadChildUnits(idxChild) {
        $.ajax({
            url: "{{ url('administrator/jsonForListUnit') }}",
            mtype: "GET",
            data: {
                "_token": "{{ csrf_token() }}",
                parent: $("#parentUnitId").val(),
            },
            success: function(e) {
                var data = e;
                $("select[name=unit_id]").empty();
                for (var i = 0; i < data.length; i++) {
                    $('select[name=unit_id]').append(
                        $('<option>', {
                            value: data[i].id,
                            text: data[i].name_unit
                        })
                    )
                }
                if (idxChild != "*") {
                    $("#unit_id").val(idxChild);
                }
            }
        })
    }



    function details(idx) {
        $.ajax({
            url: '{{ url("administrator/jsonDetailMaterial") }}',
            type: 'POST',
            method: 'post',
            data: {
                id: idx,
                "_token": "{{ csrf_token() }}",
            },
            async: false,
            success: function(res) {
                var act = $("#CrudMaterialAction").val()
                $("#location_id").val(res.location_id).trigger('change');
                $("#customers_id").val(res.customers_id).trigger('change');
                $("#parentUnitId").val(res.parentUnitId).trigger('change');
                $("#packaging_id").val(res.packaging_id).trigger('change');
                $("#name_material").val(res.name_material)
                $("#no_material").val(res.no_material)
                $("#uniqueId").val(res.uniqueId)
                loadChildUnits(res.unit_id)
                $("#QtyPerUnit").val(res.QtyPerUnit)
                $("#id").val(res.id)
                res.status_material == 1 ? $('#status_material').prop('checked', true) : $('#status_material').prop('checked', false);
                if (act == "delete") {
                    $("#formCrudMaterial .form-control,#formCrudMaterial .checkeds").prop("disabled", true);
                } else {
                    $("#formCrudMaterial .form-control,#formCrudMaterial .checkeds").prop("disabled", false);
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
                $('#crudMaterialError').html(errMsg);
            },

        })
    }
</script>
@endsection