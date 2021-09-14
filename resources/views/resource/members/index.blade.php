<!DOCTYPE html>
<html lang="en">
<head>
    <title>Members</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- bootstrap-5 css --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- fontawesome-5 css --}}
    <link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet">
    {{-- datatables-bs5 css --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css"/>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Listing (Yajra Datatables - Server Paginated)</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h3><a class="btn btn-primary" href="{{ route('members.create') }}">Create</a></h3>

    <table class="table table-bordered datatable" aria-describedby="Member listing">
        <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Email</th>
            <th scope="col">Info</th>
            <th scope="col">Is active</th>
            <th scope="col">Created At</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

{{-- jQuery-3 js --}}
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- bootstrap-5 js --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
{{-- datatables-bs5 js --}}
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>

<script type="text/javascript">
    $(function () {
        var table = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('members.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'first_name', name: 'first_name'},
                {data: 'last_name', name: 'last_name'},
                {data: 'email', name: 'email'},
                {data: 'info', name: 'info'},
                {data: 'is_active', name: 'is_active', orderable: false, searchable: false},
                {data: 'created_at', name: 'created_at'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>

</body>

</html>
