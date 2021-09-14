<!DOCTYPE html>
<html lang="en">
<head>
    <title>Members</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- bootstrap-5 css --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
        <form action="{{ $formAction }}" method="post">
            @if($member->id) @method('PATCH') @endif
            @csrf

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

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <h2 class="mb-4">Create <span class="notice">(All fields with <i class="required">*</i> are required.)</span></h2>
                </div>
            </div>

            <div class="row">
                <div class="col-auto">
                    <label for="first_name"><i class="required">*</i> First Name</label>
                    <input type="text" required class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $member->first_name) }}" placeholder="First Name">
                </div>
                <div class="col-auto">
                    <label for="last_name"><i class="required">*</i> Last Name</label>
                    <input type="text" required class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $member->last_name) }}" placeholder="Last Name">
                </div>
                <div class="col-auto">
                    <label for="email"><i class="required">*</i> Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $member->email) }}" placeholder="email@example.com">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-auto">
                    <label for="info">Info</label>
                    <textarea cols="47" class="form-control" id="info" name="info" placeholder="Description goes here">{{ old('info', $member->info) }}</textarea>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- jQuery-3 js --}}
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- bootstrap-5 js --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(function () {
    });
</script>

</body>

</html>
