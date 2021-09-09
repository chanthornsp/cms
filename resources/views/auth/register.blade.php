@extends('layouts.master')
@section('title', 'Register')
@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-6 mt-5">
            <div class="card">
                <div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <form action="/register" method="POST">
                    @csrf
                    <div class="card-header">
                        Register
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="name">
                        </div>
                        <div class="mb-4">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="email">
                        </div>
                        <div class="mb-4">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="mb-4">
                            <label for="password-confirm">Password Confirm</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password-confirm">
                        </div>

                    </div>
                    <div class="card-footer text-muted">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
