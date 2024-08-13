@extends('administrator::layouts.master')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_content">
                <h2>Welcome {{ ucwords(strtolower(session()->get("fullname"))) }}</h2>
                <div class="nav navbar-right panel_toolbox">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- top tiles -->
<div class="row">
    <div class="col-md-12">
        <div class="tile_count">
            <div class="col-md-2 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-user"></i> Total Customers</span>
                <div class="count countCustomers">0</div>
            </div>
            <div class="col-md-2 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-cubes"></i> Total Material</span>
                <div class="count countMaterial">0</div>
            </div>
            <div class="col-md-2 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-download"></i> Total Inbound</span>
                <div class="count countInbound">0</div>
            </div>
            <div class="col-md-2 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-truck"></i> Total Outbound</span>
                <div class="count countOutbound">0</div>
            </div>
            <div class="col-md-2 col-sm-4  tile_stats_count">
                <span class="count_top"><i class="fa fa-cube"></i> Total Adjusment</span>
                <div class="count countAdjust">0</div>
            </div>
        </div>
    </div>
</div>

<script>
    function countCustomers() {
        $.ajax({
            url: "{{ url('administrator/countCustomers') }}",
            method: "GET",
            success: function(res) {
                $(".countCustomers").html(res.data)
            }
        })
    }

    function countMaterial() {
        $.ajax({
            url: "{{ url('administrator/countMaterial') }}",
            method: "GET",
            success: function(res) {
                $(".countMaterial").html(res.data)
            }
        })
    }

    function countInbound() {
        $.ajax({
            url: "{{ url('administrator/countInbound') }}",
            method: "GET",
            success: function(res) {
                $(".countInbound").html(res.data)
            }
        })
    }

    function countOutbound() {
        $.ajax({
            url: "{{ url('administrator/countOutbound') }}",
            method: "GET",
            success: function(res) {
                $(".countOutbound").html(res.data)
            }
        })
    }

    function countAdjust() {
        $.ajax({
            url: "{{ url('administrator/countAdjust') }}",
            method: "GET",
            success: function(res) {
                $(".countAdjust").html(res.data)
            }
        })
    }
    countCustomers();
    countMaterial();
    countInbound();
    countOutbound();
    countAdjust();
</script>
@endsection