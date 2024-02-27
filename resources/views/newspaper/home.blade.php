@extends('layouts.home_layout');
@section('title', 'Home')
@section('content')

    @if ($articles)
        <div class="container-xl">
            @foreach ($articles as $title => $link)
                <h2>{{$title}}</h2>
                <button type="button" href='{{$link}}'></button>
            @endforeach
        </div>
    @endif
@endsection