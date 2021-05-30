@extends('layouts.main')

@section('content')

    @if($success)

        <div>

            <h1>{{ $feedback }}</h1>

            <div>
                @foreach($query as $key => $value)
                    {{ $key }}: {{ $value }}
                @endforeach
            </div>

        </div>
    @else

        <div>
            <h1>{{ $feedback }}</h1>
        </div>

    @endif

@endsection
