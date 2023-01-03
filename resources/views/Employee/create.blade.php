@extends('layouts')

@section('title', 'Create New Employee')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between mt-3 mb-3">
            <h4 class="">Create New Employee</h4>
            <a href="{{ route('employees.index') }}" class="btn btn-success btn-sm">Back Home</a>
        </div>

        <div class="card card-default">

            <div class="card card-default">

                <div class="card-body">
                    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="comapny_name"><strong>Name: </strong></label>
                            <input type="text" name="name" class="@error('name') is-invalid @enderror form-control"
                                value="{{ old('name') }}" placeholder="Enter Company Name">
                        </div>
                        @error('name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="adress"><strong> Email : </strong></label>
                            <input type="text" name="email" class="@error('email') is-invalid @enderror form-control"
                                value="{{ old('email') }}" placeholder="Enter email ">
                            @error('email')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password"><strong> password : </strong></label>
                            <input type="password" name="password"
                                class="@error('password') is-invalid @enderror form-control" value="{{ old('password') }}"
                                placeholder="Enter password ">
                            @error('password')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="adress"><strong> Company Name : </strong></label>
                            <select name="company_id" class="form-control">
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="adress"><strong>Image: </strong></label>
                            <input type="file" name="image" class="@error('image') is-invalid @enderror form-control"
                                placeholder="Enter Compnay image ">
                            @error('image')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success mt-2 "> Add Employee </button>
                    </form>
                </div>
            </div>
        </div>
    @endsection
