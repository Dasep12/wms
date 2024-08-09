@extends('administrator::layouts.master')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Users</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for=""></label>
                            <input type="text" class="form-control" name="" id="">
                        </div>
                    </div>
                    <div class="col-md-8"></div>
                    <hr>
                    <div class="form-group">
                        <button type="button" name="tloEnable" onclick="CrudRoles('create','*')" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Save</button>
                        <button type="button" name="tloEnable" onclick="Reload()" class="btn btn-sm btn-danger"><i class="fa fa-close"></i> Cancel</button>
                    </div>
                </form>

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

    function search() {
        Reload()
        $("#searching").val("")
    }
</script>
<!-- @include('administrator::roles.partials.CrudRoles') -->
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
                label: 'Username',
                name: 'username',
                align: 'left'
            }, {
                label: 'Fullname',
                name: 'fullname',
                align: 'left',
            }, {
                label: 'Role',
                name: 'roleName',
                align: 'left'
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
            var btn = `<button data-id="${btnid}" onclick="CrudRoles('update','${btnid}')"  class="btn btn-sm text-white btn-option badge-success"><i class="fa fa-pencil"></i></button>`;
            btn += `<a  data-id="${btnid}" onclick="CrudRoles('delete','${btnid}')" class="btn btn-sm text-white btn-option badge-danger"><i class="fa fa-remove"></i></a>`;
            return btn;
        }

        $(window).on('resize', function() {
            var gridWidth = $('#jqGridMain').closest('.ui-jqgrid').parent().width();
            $('#jqGridMain').jqGrid('setGridWidth', gridWidth);
        }).trigger('resize');
    })
</script>
@endsection