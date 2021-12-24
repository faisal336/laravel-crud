<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        i.required {
            color: tomato;
        }

        span.notice {
            font-size: 0.5em;
        }
    </style>


<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('members.index') }}">Listing</a> > <i class="">Member</i>
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
        File: {{ $member->image_path }}
    </div>
    <div class="mt-3">
        Is active: {{ $member->is_active ? 'Yes' : 'No' }}
    </div>
</div>

{{-- jQuery-3 js --}}
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- bootstrap-5 js --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

<script type="text/javascript">
    $(function () {
    });
</script>

</x-app-layout>
