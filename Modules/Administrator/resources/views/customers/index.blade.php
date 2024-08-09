@extends('administrator::layouts.master')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Customers</h2>
                <div class="nav navbar-right panel_toolbox">
                    <div class="input-group">
                        <input type="text" id="searching" class="form-control form-control-sm" placeholder="Search Name Customers..">
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
                    <button type="button" name="tloEnable" onclick="CrudCustomers('create','*')" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus"></i> Create</button>
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
@include('administrator::customers.partials.CrudCustomers')
<script>
    $(document).ready(function() {

        $("#jqGridMain").jqGrid({
            url: "{{ url('administrator/jsonCustomers') }}",
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
                label: 'Name Customers',
                name: 'name_customers',
                align: 'left'
            }, {
                label: 'Code Customers',
                name: 'code_customers',
                align: 'left'
            }, {
                label: 'Address',
                name: 'address',
                align: 'left'
            }, {
                label: 'Phone',
                name: 'phone',
                align: 'left'
            }, {
                label: 'Email',
                name: 'email',
                align: 'left'
            }, {
                label: 'Date Registered',
                name: 'CreatedAt',
                align: 'left',
                formatter: "date",
                formatoptions: {
                    srcformat: "ISO8601Long",
                    newformat: "d M Y H:i:s"
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
            pager: "#pager"
        });



        function actionBarangFormatter(cellvalue, options, rowObject) {
            var btnid = options.rowId;
            var btn = "";
            <?php
            if (CrudMenuPermission($MenuUrl, 1, 'edit')) { ?>
                btn += `<button data-id="${btnid}" onclick="CrudCustomers('update','${btnid}')"  class="btn btn-sm text-white btn-option badge-success"><i class="fa fa-pencil"></i></button>`;
            <?php } else { ?>
                btn += `<button disabled class="btn btn-sm text-white btn-option badge-success"><i class="fa fa-pencil"></i></button>`;
            <?php } ?>
            <?php if (CrudMenuPermission($MenuUrl, 1, 'delete')) { ?>
                btn += `<button  data-id="${btnid}" onclick="CrudCustomers('delete','${btnid}')" class="btn btn-sm text-white btn-option badge-danger"><i class="fa fa-remove"></i></button>`;
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

    function CrudCustomers(action, idx) {

        if (action == "create") {
            document.getElementById("formCrudCustomers").reset();
            $("#formCrudCustomers .form-control").prop("disabled", false);
            $(".btn-title").html('<i class="fa fa-save"></i> Create')
            $("#titleModal").html('Create Customers')
            $('#modalCrudCustomers').modal('show');
            $('#crudCustomersError').html("");
            $("#CrudCustomersAction").val('create');
            $("#crudCustomersAlertDelete").html('');
        } else if (action == "update") {
            document.getElementById("formCrudCustomers").reset();
            $(".btn-title").html('<i class="fa fa-save"></i> Update')
            $("#titleModal").html('Update Customers')
            $('#modalCrudCustomers').modal('show');
            $('#crudCustomersError').html("");
            $("#CrudCustomersAction").val('update')
            details(idx)
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            $("#crudCustomersAlertDelete").html('');
        } else if (action == "delete") {
            document.getElementById("formCrudCustomers").reset();
            $(".btn-title").html('<i class="fa fa-trash"></i> Delete')
            $("#titleModal").html('Delete Customers')
            $('#modalCrudCustomers').modal('show');
            $('#crudCustomersError').html("");
            $("#CrudCustomersAction").val('delete')
            details(idx)
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            var errMsg = '<div class="col-md-12"><div class="alert alert-danger mt-2" role="alert"><span><b>Data Will Be Delete Permanently ,sure want delete ?</span></div></div>'
            $("#crudCustomersAlertDelete").html(errMsg)
        }
    }

    function details(idx) {
        $.ajax({
            url: '{{ url("administrator/jsonDetailCustomers") }}',
            type: 'POST',
            method: 'post',
            data: {
                id: idx,
                "_token": "{{ csrf_token() }}",
            },
            async: false,
            success: function(res) {
                var act = $("#CrudCustomersAction").val()
                $("#name_customers").val(res.name_customers)
                $("#code_customers").val(res.code_customers)
                $("#email").val(res.email)
                $("#phone").val(res.phone)
                $("#address").val(res.address)
                $("#id").val(res.id)
                if (act == "delete") {
                    $("#formCrudCustomers .form-control").prop("disabled", true);
                } else {
                    $("#formCrudCustomers .form-control").prop("disabled", false);
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

        })
    }
</script>
@endsection