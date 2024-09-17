@extends('administrator::layouts.master')

@section('content')

<?php

use Illuminate\Support\Facades\DB;


?>

<style>
    #output {
        position: absolute;
        font-size: 50px;
        opacity: 0;
        right: 0;
        top: 0;
    }
</style>
<form method="post" action="{{ url('administrator/updateProfile') }}" enctype="multipart/form-data">
    @csrf

    <div class="row">
        @if(session('msg'))
        <div class="col-lg-12">
            <div class="alert alert-warning">
                <strong>{{ session('msg') }}</strong>
            </div>
        </div>
        @endif
        <div class="col-md-4 col-sm-4  ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>User Profile</h2>
                    <div class="nav navbar-right panel_toolbox">
                        <div class="input-group">
                            <!-- <input type="text" id="searching" class="form-control form-control-sm" placeholder="Search Name Material..">
                        <span class="input-group-btn">
                            <button onclick="search()" class="btn-filter btn btn-secondary btn-sm" type="button"><i class="fa fa-search"></i> Search</button>
                        </span> -->
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="text-center">
                        @if($data->profile)
                        <img id="img-avatar" src="{{ asset('assets/images/' . $data->profile) }}" class="img-thumbnail" alt="Photo" width="160" height="140" />
                        @else
                        <img id="img-avatar" src="{{ asset('assets/images/user_2.png') }}" class="img-thumbnail" alt="Photo" width="160" height="140" />
                        @endif
                        <br /><br />
                        <div id="btn-upload" style="position: relative;overflow: hidden;cursor:pointer" class="btn btn-dark btn-sm btn-block">
                            <i class="fa fa-upload"></i> Upload Photo
                            <input style="cursor:pointer" type="file" id="output" name="profile" accept="image/*" onchange="loadFile(event,'img-avatar')" />
                        </div>
                        <script>
                            var loadFile = function(event, obj) {
                                var Foto = document.getElementById(obj);
                                Foto.src = URL.createObjectURL(event.target.files[0]);
                            };
                        </script>
                        <br />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-8  ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Detail</h2>
                    <div class="nav navbar-right panel_toolbox">
                        <div class="input-group">
                            <!-- <input type="text" id="searching" class="form-control form-control-sm" placeholder="Search Name Material..">
                        <span class="input-group-btn">
                            <button onclick="search()" class="btn-filter btn btn-secondary btn-sm" type="button"><i class="fa fa-search"></i> Search</button>
                        </span> -->
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-12">
                        <input type="text" name="id" id="id" hidden value="{{ $data->id }}">
                        <label class="control-label" for="username" style="padding-top:8px !important">User Name</label>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-hashtag"></i></span>
                            </div>
                            <input required class="form-control text-box single-line" data-val="true" id="username" name="username" type="text" value="{{ $data->username }}" />
                        </div>

                        <label class="control-label" for="fullname" style="padding-top:8px !important">Full Name</label>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-hashtag"></i></span>
                            </div>
                            <input required class="form-control text-box single-line" data-val="true" id="fullname" name="fullname" type="text" value="{{ $data->fullname }}" />
                        </div>

                        <label class="control-label" for="email" style="padding-top:8px !important">Email</label>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input required class="form-control text-box single-line" data-val="true" id="email" name="email" type="text" value="{{ $data->email }}" />
                        </div>

                        <label class="control-label" for="UserName" style="padding-top:8px !important">Phone</label>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                            </div>
                            <input required class="form-control text-box single-line" data-val="true" id="phone" name="phone" type="text" value="{{ $data->phone }}" />
                        </div>

                        <label class="control-label" for="password" style="padding-top:8px !important">Password</label>
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            <input class="form-control text-box single-line" data-val="true" id="password" name="password" type="password" value="" />
                        </div>
                        <small class="text-danger ">*field password di isi jika ingin mengganti password</small>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {

    })
</script>
@endsection