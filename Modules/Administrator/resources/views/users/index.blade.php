@extends('administrator::layouts.master')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Users</h2>
                <div class="nav navbar-right panel_toolbox">
                    <div class="input-group">
                        <input type="text" id="searching" class="form-control form-control-sm" placeholder="Search Name Roles..">
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
                    <button type="button" name="tloEnable" onclick="CrudUsers('create','*')" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus"></i> Create</button>
                    <button type="button" name="tloEnable" onclick="Reload()" class="btn btn-sm btn-outline-secondary"><i class="fa fa-refresh"></i> Refresh</button>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
</div>
<script>
    function Reload() {
        $("#jqGridMain").jqGrid('setGridParam', {
            datatype: 'json',
            mtype: 'GET',
            postData: {
                id: "",
                search: $("#searching").val()
            }
        }).trigger('reloadGrid');
    }

    function ReloadModalMenu() {
        $("#jqGridMainModal").jqGrid('setGridParam', {
            datatype: 'json',
            mtype: 'GET',
            postData: {
                role_id: $("#role_id").val(),
                user_id: $("#user_id").val()
            }
        }).trigger('reloadGrid');
    }

    function search() {
        ReloadBarang()
        $("#searching").val("")
    }
</script>
@include('administrator::users.partials.CrudUsers')
<script>
    $(document).ready(function() {

        $("#jqGridMain").jqGrid({
            url: "{{ url('administrator/jsonUsers') }}",
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
                label: 'Role Name',
                name: 'roleName',
                align: 'left'
            }, {
                label: 'Username',
                name: 'username',
                align: 'left',
            }, {
                label: 'Status ',
                name: 'status_user',
                align: 'center',
                formatter: function(cellvalue, options, rowObject) {
                    var status = rowObject.status_user == 1 ? 'Active' : 'Inactive';
                    var badge = rowObject.status_user == 1 ? 'badge-success' : 'badge-danger';
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
            pager: "#pager"
        });



        function actionBarangFormatter(cellvalue, options, rowObject) {
            var btnid = options.rowId;
            var btn = `<button data-id="${btnid}" onclick="CrudUsers('update','${btnid}')"  class="btn btn-sm text-white btn-option badge-success"><i class="fa fa-pencil"></i></button>`;
            btn += `<a  data-id="${btnid}" onclick="CrudUsers('delete','${btnid}')" class="btn btn-sm text-white btn-option badge-danger"><i class="fa fa-remove"></i></a>`;
            return btn;
        }

        $(window).on('resize', function() {
            var gridWidth = $('#jqGridMain').closest('.ui-jqgrid').parent().width();
            $('#jqGridMain').jqGrid('setGridWidth', gridWidth);
        }).trigger('resize');
    })

    function loadFieldRoles(idx) {
        var Grid = $('#jqGridMain'),
            selRowId = Grid.jqGrid('getGridParam', 'selrow'),
            idRoles = Grid.jqGrid('getCell', idx, 'id'),
            roleName = Grid.jqGrid('getCell', idRoles, 'roleName'),
            code_role = Grid.jqGrid('getCell', idRoles, 'code_role');
        $("#id").val(idx)
        $("#roleName").val(roleName)
        $("#code_role").val(code_role)
    }

    function CrudUsers(action, idx) {

        if (action == "create") {
            document.getElementById("formCrudUsers").reset();
            $("#formCrudUsers .form-control").prop("disabled", false);
            $(".btn-title").html('<i class="fa fa-save"></i> Create')
            $("#titleModal").html('Create Units')
            $('#modalCrudUsers').modal('show');
            $('#CrudUsersError').html("");
            $("#CrudUsersAction").val('create');
            $("#CrudUsersAlertDelete").html('');
            ReloadModalMenu()
            $("#formCrudUsers .form-control").attr("readonly", false)
        } else if (action == "update") {
            document.getElementById("formCrudUsers").reset();
            $(".btn-title").html('<i class="fa fa-save"></i> Update')
            $("#titleModal").html('Update Units')
            $('#modalCrudUsers').modal('show');
            $('#CrudUsersError').html("");
            $("#CrudUsersAction").val('update')
            ReloadModalMenu()
            loadFieldRoles(idx)
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            $("#CrudUsersAlertDelete").html('');
            $("#formCrudUsers .form-control").attr("readonly", false)
        } else if (action == "delete") {
            document.getElementById("formCrudUsers").reset();
            $("#formCrudUsers .form-control").attr("readonly", true)
            loadFieldRoles(idx)
            ReloadModalMenu()
            $(".btn-title").html('<i class="fa fa-trash"></i> Delete')
            $("#titleModal").html('Delete Units')
            $('#modalCrudUsers').modal('show');
            $('#CrudUsersError').html("");
            $("#CrudUsersAction").val('delete')
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            var errMsg = '<div class="col-md-12"><div class="alert alert-danger mt-2" role="alert"><span><b>Data Will Be Delete Permanently ,sure want delete ?</span></div></div>'
            $("#CrudUsersAlertDelete").html(errMsg)
        }
    }
</script>
@endsection