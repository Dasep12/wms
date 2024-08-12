@extends('administrator::layouts.master')

@section('content')

<?php

use Illuminate\Support\Facades\DB;


?>
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Summary Stock</h2>
                <div class="nav navbar-right panel_toolbox">
                    <div class="input-group">
                        <!-- <input type="text" id="searching" class="form-control form-control-sm" placeholder="Search Name Unit..">
                        <span class="input-group-btn">
                            <button onclick="search()" class="btn-filter btn btn-secondary btn-sm" type="button"><i class="fa fa-search"></i> Search</button>
                        </span> -->
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="jqGridMain"></table>
                <div id="pager"></div>

                <hr>

                <div class="form-group">

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
    $(document).ready(function() {

        $("#jqGridMain").jqGrid({
            url: "{{ url('administrator/jsonSummary') }}",
            datatype: "json",
            mtype: "GET",
            postData: {
                "_token": "{{ csrf_token() }}",
                parent: "*"
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
                width: 140
            }, {
                label: 'Material Number',
                name: 'no_material',
                align: 'left',
                width: 150
            }, {
                label: 'Unique Id',
                name: 'uniqueId',
                align: 'center',
                width: 80
            }, {
                label: 'Unit',
                name: 'unit',
                align: 'center',
                width: 80,
                hidden: true
            }, {
                label: 'Units',
                name: 'units',
                align: 'center',
                width: 100
            }, {
                label: 'Packaging',
                name: 'packaging',
                align: 'center',
                width: 110
            }, {
                label: 'Qty Unit',
                name: 'QtyUnit',
                align: 'center',
                width: 90,
                hidden: true
            }, {
                label: 'Qty Units',
                name: 'QtyUnits',
                align: 'center',
                width: 100
            }, {
                label: 'Qty Packaging',
                name: 'QtyPackaging',
                align: 'center',
                width: 90
            }, {
                label: 'Updated At',
                name: 'updated_at',
                align: 'center',
                width: 140,
                formatter: "date",
                formatoptions: {
                    srcformat: "ISO8601Long",
                    newformat: "d F Y H:i:s"
                }
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
            rownumbers: true,
            rownumWidth: 30,
            rowNum: 15,
            height: 'auto',
            shrinkToFit: false,
            autowidth: true,
            pager: "#pager",
            loadComplete: function() {
                $(this).jqGrid('setGridWidth', $("#jqGridMain").closest(".ui-jqgrid").parent().width());
            },
            subGrid: true,
            subGridRowExpanded: loadDetailTransaksi

        });

        function loadDetailTransaksi(subgrid_id, row_id) {
            // Function to load subgrid data
            var subgrid_table_id = subgrid_id + "_t";
            var pager_id = "p_" + subgrid_table_id;
            $("#" + subgrid_id).html("<table id='" + subgrid_table_id + "' class='scroll'></table><div id='" + pager_id + "' class='scroll'></div>");
            $("#" + subgrid_table_id).jqGrid({
                url: "{{ url('administrator/jsonDetailSummary') }}",
                mtype: "GET",
                datatype: "json",
                postData: {
                    id: row_id,
                    "_token": "{{ csrf_token() }}",
                },
                page: 1,
                colModel: [{
                        label: "Date",
                        name: "dates",
                        width: 150,
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d F Y H:i:s"
                        }
                    }, {
                        label: "Trans",
                        name: "types_trans",
                        width: 50,
                        align: "center"
                    }, {
                        label: "Type",
                        name: "types",
                        width: 50,
                        align: "center"
                    },
                    {
                        label: "Units",
                        name: "units",
                        width: 68,
                        align: 'center',
                    }, {
                        label: "Packaging",
                        name: "packaging",
                        width: 95,
                        align: 'center',
                    },
                    {
                        label: "Units",
                        name: "begin_stock_units",
                        width: 60,
                        align: 'center',
                    }, {
                        label: "Packaging",
                        name: "begin_stock_packaging",
                        width: 65,
                        align: 'center',
                    },
                    {
                        label: "Units",
                        name: "QtyUnits",
                        width: 60,
                        align: 'center',
                    }, {
                        label: "Packaging",
                        name: "QtyPackaging",
                        width: 65,
                        align: 'center',
                    },
                    {
                        label: "Units",
                        name: "EndStockUnits",
                        width: 60,
                        align: 'center',
                    }, {
                        label: "Packaging",
                        name: "EndStockPackaging",
                        width: 65,
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
                width: '100%',
                rowNum: 15,
                caption: "Log Book",
                pager: "#" + pager_id,
            });

            jQuery("#" + subgrid_table_id).jqGrid('setGroupHeaders', {
                useColSpanStyle: true,
                groupHeaders: [{
                    startColumnName: 'units',
                    numberOfColumns: 2,
                    titleText: 'Detail'
                }, {
                    startColumnName: 'begin_stock_units',
                    numberOfColumns: 2,
                    titleText: 'Begin Stock'
                }, {
                    startColumnName: 'QtyUnits',
                    numberOfColumns: 2,
                    titleText: 'IN/OUT Stock'
                }, {
                    startColumnName: 'EndStockUnits',
                    numberOfColumns: 2,
                    titleText: 'Final Stock'
                }, {
                    startColumnName: 'types_trans',
                    numberOfColumns: 2,
                    titleText: 'Types'
                }]
            });
        }


        jQuery("#jqGridMain").jqGrid('setGroupHeaders', {
            useColSpanStyle: true,
            groupHeaders: [{
                startColumnName: 'units',
                numberOfColumns: 2,
                titleText: 'Detail'
            }, {
                startColumnName: 'QtyUnit',
                numberOfColumns: 3,
                titleText: 'Final Stock'
            }]
        });

        $(window).on('resize', function() {
            var gridWidth = $('#jqGridMain').closest('.ui-jqgrid').parent().width();
            $('#jqGridMain').jqGrid('setGridWidth', gridWidth);
        }).trigger('resize');
    })
</script>
@endsection