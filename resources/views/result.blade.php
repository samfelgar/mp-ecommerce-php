@extends('layouts.main')

@section('content')

    <div style="margin: 5em 5em;">

        @if($success)

            <h1>{{ $feedback }}</h1>

            <div>
                @foreach($query as $key => $value)
                    <div>
                        <strong>{{ $key }}</strong>: {{ $value }}
                    </div>
                @endforeach
            </div>

        @else
            <h1>{{ $feedback }}</h1>
        @endif

    </div>

@endsection
