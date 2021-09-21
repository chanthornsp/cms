@extends('layouts.admin-layout')
@section('title','Admin Dashboard')
@section('content-header','Dashboard')
@section('content')
<h1>Welcome {{ auth()->guard('admin')->user()->name }}</h1>
@endsection
