<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- datatables-bs5 css --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css"/>
    {{-- datatables-bs5 js --}}
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>

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
                <th scope="col">Files</th>
                <th scope="col">Is active</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <script type="text/javascript">

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
                    {data: "image_path" , name: 'image_path', orderable: false, searchable: false,
                        render : function(data, type, row, meta) {
                            return `
                            <a href="${row['image_path']}" target="_blank"><i class="fa fa-eye"></i>View</a>
                               `;
                        }
                    },
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

                $('.datatable').on('click', 'tbody .details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = table.row(tr);

                    if (row.child.isShown()) {
                        row.child.hide();
                    } else {
                        axios.get("{{ route('members.getInnerHTML') }}")
                            .then(function (response) {
                                row.child(response.data).show();
                            })
                            .catch(function (error) {
                                //
                            })
                            .then(function () {
                                // always executed
                            });
                    }
                });
            });

            function deleteRecord(id) {
                if (!confirm("Are you sure you want to Delete This?"))
                    return false;

                let url = "{{ route('members.destroy', 'id') }}";
                url = url.replace('id', id);


                axios.post(url, {"_method": 'delete'})
                    .then(function (response) {
                        alert(response.data);

                        window.location.reload()
                    })
                    .catch(function (error) {
                        alert(error)
                    })
                    .then(function () {
                        // always executed
                    });
            }
        </script>
</x-app-layout>

