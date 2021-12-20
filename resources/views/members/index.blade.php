<!DOCTYPE html>
<html lang="en">
<head>
    <title>Members</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    {{-- bootstrap-5 css --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- fontawesome-5 css --}}
    <link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet">
    {{-- datatables-bs5 css --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css"/>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Listing (Datatables - Server Paginated)</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h3><a class="btn btn-primary" href="{{ route('members.create') }}">Create</a></h3>

    <table class="table table-bordered table-striped datatable" aria-describedby="Member listing">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
{{-- datatables-bs5 js --}}
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>

<script type="text/javascript">
    function format (row) {
        return 'Hi Im Testing Row And my Index is 1'+ '<br>'+
            'Hi Im Testing Row And my Index is 2: '
    }
    
    $(function () {
        let table = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            bFilter: false,
            ajax: "{{ route('members.list') }}",

            columns: [
                {"data": "id", name: 'id', orderable: false, searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'first_name', name: 'first_name', orderable: false, searchable: false},
                {data: 'last_name', name: 'last_name', orderable: false, searchable: false},
                {data: 'email', name: 'email', orderable: false, searchable: false},
                {data: 'info', name: 'info', orderable: false, searchable: false},
                {data: 'is_active', name: 'is_active', orderable: false, searchable: false},
                {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                {data: "action" , name: 'action', orderable: false, searchable: false,
                    render : function(data, type, row, meta) {
                        let show_url = "{{ route('members.show', ['member' => ':id']) }}";
                        show_url = show_url.replace(':id', row.id);

                        let edit_url = "{{ route('members.edit', ['member' => ':id']) }}";
                        edit_url = edit_url.replace(':id', row.id);

                        return `
                            <a href="${show_url}" class="edit btn btn-primary btn-sm"><i class="fa fa-eye"></i></a> |
                            <a href="${edit_url}" class="edit btn btn-success btn-sm"><i class="fa fa-edit"></i></a> |
                            <button type="button" class="destroy btn btn-danger btn-sm" id="deleteRecord" onclick="deleteRecord(${row.id})"><i class="fa fa-trash"></i></button> |
                            <button type="button" class="btn btn-info btn-sm details-control"><i class="fa fa-arrow-down"></i></button>
                        `;
                    }
                },
            ],
        });

        var detailRows = [];

        $('.datatable tbody').on( 'click', '.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();

                // Remove from the 'open' array
                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );
                row.child( format( row.data() ) ).show();

                // Add to the 'open' array
                if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                }
            }
        } );

        table.on( 'draw', function () {
            $.each( detailRows, function ( i, id ) {
                $('#'+id+'.details-control').trigger( 'click' );
            } );
        } );
    });

    function deleteRecord(id) {
        if (!confirm("Are you sure you want to Delete This?"))
            return false;

        let token = $("meta[name='csrf-token']").attr("content");
        let url = "{{ route('members.destroy', 'id') }}";
        url = url.replace('id', id);

        $.ajax({
            url: url,
            type: 'post',
            data: {
                "id": id,
                "_token": token,
                "_method": 'delete',
            },
            success: function (response) {
                alert(response.message);
                window.location.reload()
            },
            error: function (error) {
                alert("Please Check Error")
            }
        });
    }
</script>
</body>
</html>
