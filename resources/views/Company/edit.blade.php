@extends('layouts')

@section('title', 'Edit Company')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between mt-3 mb-3">
            <h4 class="">Edit {{ $company->name }}</h4>
            <a href="{{ route('companies.index') }}" class="btn btn-success btn-sm">Back Home</a>
        </div>


        <div class="card card-default">

            <div class="card-body">
                <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="comapny_name"><strong> Company Name: </strong></label>
                        <input type="text" name="name" class="@error('name') is-invalid @enderror form-control"
                            value="{{ $company->name }}" placeholder="Enter Company Name">
                    </div>
                    @error('name')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="adress"><strong> Company Adress : </strong></label>
                        <input type="text" name="adress" class="@error('adress') is-invalid @enderror form-control"
                            value="{{ $company->adress }}" placeholder="Enter Compnay Adress ">
                        @error('adress')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="adress"><strong> Company Logo : </strong></label>
                        <input type="file" name="logo" class="form-control" placeholder="Enter Compnay Logo ">
                    </div>
                    <button type="submit" class="btn btn-success mt-2 "> Update Company </button>
                </form>
            </div>
        </div>
    @endsection
