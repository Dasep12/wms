<div class="modal  fade" id="modalCrudAddMaterial" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalCrudAddMaterial" aria-hidden="true">
    <div class="modal-lg modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="titleModal">Material List</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="jqGridListMaterial"></table>
                <div id="pagerMaterial"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="button" onclick="getDataMaterial()" class="btn btn-primary btn-sm btn-title"><i class="fa fa-check"></i> Select</button>
            </div>

            <div id="CrudInboundError"></div>


        </div>
    </div>
</div>

<script>
    $("#jqGridListMaterial").jqGrid({
        url: "{{ url('administrator/jsonListMaterialByCustomers') }}",
        datatype: "json",
        mtype: "GET",
        postData: {
            customers_id: $("#customer_id").val(),
            "_token": "{{ csrf_token() }}",
            status: 1
        },
        colModel: [{
            label: 'ID',
            name: 'id',
            key: true,
            hidden: true,
        }, {
            label: 'Name Material',
            name: 'name_material',
            align: 'left',
            width: 120
        }, {
            label: 'Material Number',
            name: 'no_material',
            align: 'left',
            width: 120
        }, {
            label: 'Uniqe No',
            name: 'uniqueId',
            align: 'center',
            width: 70
        }, {
            label: 'Units',
            name: 'unit',
            align: 'center',
            width: 90
        }, {
            label: 'Satuan',
            name: 'satuan',
            align: 'center',
            width: 90
        }, {
            label: 'Packaging',
            name: 'name_packaging',
            align: 'center',
            width: 90
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
        width: '100%',
        height: 250,
        rowNum: 10,
        rowList: [10, 30, 50],
        pager: "#pagerMaterial"
    });

    $("#jqGridListMaterial").navGrid("#pagerMaterial", {
        add: false,
        edit: false,
        del: false,
        search: false,
        refresh: true
    });


    function getDataMaterial() {
        var Grid = $('#jqGridListMaterial'),
            selRowId = Grid.jqGrid('getGridParam', 'selrow'),
            idMaterialField = Grid.jqGrid('getCell', selRowId, 'id'),
            name_material = Grid.jqGrid('getCell', selRowId, 'name_material'),
            no_material = Grid.jqGrid('getCell', selRowId, 'no_material'),
            uniqueId = Grid.jqGrid('getCell', selRowId, 'uniqueId'),
            material_id = Grid.jqGrid('getCell', selRowId, 'id'),
            unit = Grid.jqGrid('getCell', selRowId, 'unit'),
            unitQty = Grid.jqGrid('getCell', selRowId, 'unitQty'),
            packaging = Grid.jqGrid('getCell', selRowId, 'name_packaging'),
            satuan = Grid.jqGrid('getCell', selRowId, 'satuan');

        //$("#qtyPerUnitLabel").html(satuan)
        $("#qtyUnitLabel").html(unit)
        $("#qtyStorageLabel").html(packaging)
        $("#qtySatuanLabel").html(satuan)
        $("#QtyStorageLabelDeliveryMaterialField").val(packaging)
        $("#SatuanDeliveryMaterialField").val(satuan)

        if (materialExists(idMaterialField)) {
            alert("Material has been added in list")
        } else {
            $("#nameMaterialField").val(name_material)
            $("#noMaterialField").val(no_material)
            $("#UniqueIdMaterialField").val(uniqueId)
            $("#UnitMaterialField").val(unit)
            $("#UnitsMaterialField").val(satuan)
            $("#PackagingMaterialField").val(packaging)
            // $("#QtyUnitMaterialField").val(unitQty)
            $("#idMaterialField").val(idMaterialField)
            $(".form-control").removeClass("parsley-error");
            $(".parsley-required").html("");
            document.querySelectorAll(".parsley-errors-list").forEach(el => el.remove());
            $('#modalCrudAddMaterial').modal('hide');
        }



    }

    function materialExists(idx) {
        return dataMaterialInbound.some(function(el) {
            return el.id == idx;
        });
    }
</script>