@extends('layouts')

@section('title', 'All Employees')

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush


@section('content')
    <div class="container mt-5">
        <h3>Show {{ $company->name }}'s Employees</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($company->employees as $employee)
                    <tr>
                        <td>
                            {{ $employee->name }}
                        </td>
                        <td>
                            {{ $employee->email }}
                        </td>
                        <td>
                            <img src="{{ asset('/' . $employee->image) }}" width="50px" alt="">
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('employees.edit', $employee->id) }}"
                                    class="edit btn btn-success btn-sm ml-1 mr-1">Edit</a>
                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm(\'Are You Sure Want to Delete?\')">Delete</a>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
