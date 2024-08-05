@extends('operator::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('operator.name') !!}</p>
@endsection
