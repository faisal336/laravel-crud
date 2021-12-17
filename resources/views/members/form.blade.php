<!DOCTYPE html>
<html lang="en">
<head>
    <title>Members</title>
    <meta name="csrf_token" content="{{ csrf_token() }}">

    {{-- bootstrap-5 css --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- fontawesome-5 css --}}
    <link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet">

    <style>
        i.required {
            color: tomato;
        }

        span.notice {
            font-size: 0.5em;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="mt-3">
        <a href="{{ route('members.index') }}">Listing</a> > <i class="text-gray-200">Member Form</i>
    </div>

    <div class="d-flex justify-content-center">
        <form method="post" action="{{ $formAction }}">
            @csrf
            @if($member->id)
                @method('patch')
            @else
                @method('post')
            @endif

            <input type="hidden" name="id" id="id" value="{{ $member->id }}"/>

            <div class="row">
                <div class="col">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(Session('success'))
                        <div class="alert alert-success success">
                            {{ Session('success') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <h2 class="mb-4">Create <span class="notice">(All fields with <i class="required">*</i> are required.)</span>
                    </h2>
                </div>
            </div>

            <div class="row">
                <div class="col-auto">
                    <label for="first_name"><i class="required">*</i> First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name"
                           value="{{ old('first_name', $member->first_name) }}" placeholder="First Name" required>
                </div>
                <div class="col-auto">
                    <label for="last_name"><i class="required">*</i> Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name"
                           value="{{ old('last_name', $member->last_name) }}" placeholder="Last Name" required>
                </div>
                <div class="col-auto">
                    <label for="email"><i class="required">*</i> Email</label>
                    <input type="text" class="form-control" id="email" name="email"
                           value="{{ old('email', $member->email) }}" placeholder="email@example.com" required>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-auto">
                    <label for="info">Info</label>
                    <textarea cols="47" class="form-control" id="info" name="info"
                              placeholder="Description goes here">{{ old('info', $member->info) }}</textarea>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3" id="add">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- jQuery-3 js --}}
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- bootstrap-5 js --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("form").submit(function (event) {
            event.preventDefault();

            let id = $('#id').val()
            let url = $('form').prop('action')
            let token = $("input[name='_token']").val()
            let method = $("input[name='_method']").val()

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    "first_name": $("#first_name").val(),
                    "last_name": $("#last_name").val(),
                    "email": $("#email").val(),
                    "info": $("#info").val(),
                    "_token": token,
                    "_method": method,
                },
                dataType: "json",
                encode: true,
                success: function (response) {
                    if (response) {
                        alert(response.message);

                        if (!id) {
                            $("form")[0].reset();
                        }
                    }
                },
                error: function (error) {
                    alert(error.responseJSON.message)
                }
            });
        });
    });
</script>

</body>

</html>
