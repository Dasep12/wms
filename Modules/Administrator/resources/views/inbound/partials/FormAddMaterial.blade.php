<div class="modal  fade" id="modalFormAddMaterial" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalCrudAddMaterial" aria-hidden="true">
    <div class="modal-lg modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="titleModal">Form Material List</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="materialFormField" data-parsley-validate class="form-horizontal form-label-left">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="control-label col-md-4 col-sm-4 col-xs-4">Name Material</label>
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <input type="text" hidden name="idMaterialField" id="idMaterialField">
                                    <input type="text" hidden name="actionListMaterialField" id="actionListMaterialField">
                                    <input type="text" required readonly class="form-control" id="nameMaterialField">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-4 col-sm-4 col-xs-4">No Material</label>
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <input type="text" readonly class="form-control" id="noMaterialField">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-4 col-sm-4 col-xs-4">Unique No</label>
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <input type="text" readonly class="form-control" id="UniqueIdMaterialField">
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="control-label col-md-4 col-sm-4 col-xs-4">Unit</label>
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <input type="text" readonly class="form-control" id="UnitMaterialField">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="UnitsMaterialField" class="control-label col-md-4 col-sm-4 col-xs-4">Units</label>
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <input type="text" readonly class="form-control" id="UnitsMaterialField">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="PackagingMaterialField" class="control-label col-md-4 col-sm-4 col-xs-4">Packaging</label>
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <input type="text" readonly class="form-control" id="PackagingMaterialField">
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">

                            <div class="form-group row">
                                <label class="control-label col-md-4 col-sm-4 col-xs-4">Qty Inbound </label>
                                <div class="col-md-8 col-sm-8 input-group">
                                    <input type="text" id="QtyUnitInbound" class="form-control" onkeypress="return isNumberKey(event)">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 13px !important;background: #E1E1E1;" class="input-group-text" id="qtyUnitLabel"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-4 col-sm-4 col-xs-4"></label>
                                <div class="col-md-8 col-sm-8 input-group">
                                    <input type="text" id="QtyUnitsInbound" class="form-control" onkeypress="return isNumberKey(event)">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 13px !important;background: #E1E1E1;" class="input-group-text" id="qtySatuanLabel"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-4 col-sm-4 col-xs-4"></label>
                                <div class="col-md-8 col-sm-8 input-group">
                                    <input type="text" id="QtyPackagingInbound" class="form-control" onkeypress="return isNumberKey(event)">
                                    <div class="input-group-prepend">
                                        <span style="font-size: 13px !important;background: #E1E1E1;" class="input-group-text" id="qtyStorageLabel"></span>
                                    </div>

                                    <input hidden type="text" name="QtyStorageLabelDeliveryMaterialField" id="QtyStorageLabelDeliveryMaterialField">

                                    <input hidden type="text" name="SatuanDeliveryMaterialField" id="SatuanDeliveryMaterialField">
                                </div>
                            </div>


                        </div>
                    </div>

            </div>

            <div class="modal-footer">
                <div class="ml-3" style="position:absolute; left:0 !important">
                    <div class="row">
                        <div class="col">
                            <!-- data-toggle="modal" data-target="#modalCrudAddMaterial" -->
                            <button type="button" onclick="getMaterialByCustomersId()" class="btn btn-sm btn-outline-secondary btnFindMaterial"><i class="fa fa-search"></i> Find Material</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-primary btn-sm btn-title btn-formAddMaterial"><i class="fa fa-check"></i> Select</button>
            </div>
            </form>
            <div id="CrudInboundError"></div>


        </div>
    </div>
</div>

<script>
    $('#materialFormField').submit(function(e) {
        e.preventDefault();
        var f = $(this);
        f.parsley().validate();

        if (f.parsley().isValid()) {
            var act = $("#actionListMaterialField").val();
            var id = $("#idMaterialField").val(),
                no_material = $("#noMaterialField").val(),
                name_material = $("#nameMaterialField").val(),
                uniqid = $("#UniqueIdMaterialField").val(),
                unit = $("#UnitMaterialField").val(),
                units = $("#UnitsMaterialField").val(),
                packaging = $("#PackagingMaterialField").val(),
                qtyUnit = $("#QtyUnitInbound").val(),
                qtyUnits = $("#QtyUnitsInbound").val(),
                qtyPackaging = $("#QtyPackagingInbound").val();
            var datas = {
                'id': id,
                'no_material': no_material,
                'name_material': name_material,
                'uniqid': uniqid,
                'unit': unit,
                'units': units,
                'packaging': packaging,
                'qtyUnit': qtyUnit,
                'qtyUnits': qtyUnits,
                'qtyPackaging': qtyPackaging,
                'detail_id': ''
            }
            if (act == "create") {
                dataMaterialInbound.push(datas);
                reloadgridInboundList(dataMaterialInbound)
            } else if (act == "update") {
                updateMaterialList(dataMaterialInbound, id, datas)
                reloadgridInboundList(dataMaterialInbound)
            } else if (act == "delete") {
                dataMaterialInbound = dataMaterialInbound.filter(item => item.id != id);
                reloadgridInboundList(dataMaterialInbound);
            }
            $('#modalFormAddMaterial').modal('hide');
        }
    })

    function updateMaterialList(array, id, newData) {
        // Find the index of the element with the given id
        const index = array.findIndex(element => element.id == id);

        if (index != -1) {
            // Update the element's properties with the new data
            array[index] = {
                ...array[index],
                ...newData
            };
            return true; // Return true if the update was successful
        } else {
            return false; // Return false if the element was not found
        }
    }

    function getMaterialByCustomersId() {
        $("#jqGridListMaterial").jqGrid('setGridParam', {
            datatype: 'json',
            mtype: 'GET',
            postData: {
                customers_id: $("#customer_id").val(),
            }
        }).trigger('reloadGrid');
        $('#modalCrudAddMaterial').modal('show');
    }
</script>