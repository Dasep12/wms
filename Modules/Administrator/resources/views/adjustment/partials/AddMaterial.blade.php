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
        url: "{{ url('administrator/jsonStockListMaterialByCustomers') }}",
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
            name: 'units',
            align: 'center',
            width: 90
        }, {
            label: 'Unit',
            name: 'unit',
            align: 'center',
            width: 90
        }, {
            label: 'Packaging',
            name: 'packaging',
            align: 'center',
            width: 90
        }, {
            label: 'Qty Units',
            name: 'QtyUnits',
            align: 'center',
            width: 90
        }, {
            label: 'Qty Unit',
            name: 'QtyUnit',
            align: 'center',
            width: 90
        }, {
            label: 'Qty Packaging',
            name: 'QtyPackaging',
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
            units = Grid.jqGrid('getCell', selRowId, 'units'),
            packaging = Grid.jqGrid('getCell', selRowId, 'packaging'),
            StockQtyUnit = Grid.jqGrid('getCell', selRowId, 'QtyUnit'),
            StockQtyUnits = Grid.jqGrid('getCell', selRowId, 'QtyUnits'),
            StockQtyPackaging = Grid.jqGrid('getCell', selRowId, 'QtyPackaging');

        $("#qtyUnitLabel").html(unit)
        $("#qtyStorageLabel").html(packaging)
        $("#qtySatuanLabel").html(units)
        $(".qtyUnitLabel").html(unit)
        $(".qtyStorageLabel").html(packaging)
        $(".qtySatuanLabel").html(units)
        $("#QtyStorageLabelDeliveryMaterialField").val(packaging)
        $("#SatuanDeliveryMaterialField").val(units)

        $(".QtyUnitAdjustment").val(StockQtyUnit)
        $(".QtyUnitsAdjustment").val(StockQtyUnits)
        $(".QtyPackagingAdjustment").val(StockQtyPackaging)


        if (materialExists(idMaterialField)) {
            // alert("Material has been added in list")
            doSuccess("", "Material has been added in list", "warning")
        } else {
            $("#nameMaterialField").val(name_material)
            $("#details_unit").attr("placeholder", "Details Unit Per " + unit);
            $("#noMaterialField").val(no_material)
            $("#UniqueIdMaterialField").val(uniqueId)
            $("#UnitMaterialField").val(unit)
            $("#UnitsMaterialField").val(units)
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
        return dataMaterialAdjustment.some(function(el) {
            return el.id == idx;
        });
    }
</script>