@extends('layouts.main')

@section('content')

    <div style="margin: 5em 0;">

        @if($success)

            <h1>{{ $feedback }}</h1>

            <div>
                @foreach($query as $key => $value)
                    {{ $key }}: {{ $value }}
                @endforeach
            </div>

        @else
            <h1>{{ $feedback }}</h1>
        @endif

    </div>

@endsection
