@extends('layouts')

@section('title', 'All Compaines')

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush


@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between mt-3 mb-3">
            <h4 class="">All Companies</h4>
            <a href="{{ route('companies.create') }}" class="btn btn-success btn-sm">Create New</a>
        </div>

        <table class="table table-bordered yajra-datatable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Adress</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function() {

            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('getCompanies') }}",
                columns: [{
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'adress',
                        name: 'adress'
                    },
                    {
                        data: 'logo',
                        name: 'logo',
                        "render": function(data, type, full, meta) {
                            return "<img src=\"" + data + "\" height=\"50\"/>";
                        },
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

        });
    </script>
@endpush
