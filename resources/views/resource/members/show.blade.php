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
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('members.index') }}">Listing</a> > <i class="text-gray-200">Member</i>
    </div>
    <div class="mt-3">
        Full Name: {{ $member->full_name }}
    </div>
    <div class="mt-3">
        Email: {{ $member->email }}
    </div>
    <div class="mt-3">
        Info: {{ $member->info }}
    </div>
    <div class="mt-3">
        Is active: {{ $member->is_active ? 'Yes' : 'No' }}
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
