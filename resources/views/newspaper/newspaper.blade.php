@extends('layouts.home_layout')
@section('title', 'Home')
@section('content')
    @if (isset($articles))
        <section class="container-xl h-75 bg-light my-4 overflow-auto rounded">
            @foreach ($articles as $key => $article)
                @foreach ($article as $title => $link)
                <div class="d-flex justify-content-between align-items-center m-2 p-2 rounded bg-white">
                    <h5 class="w-75 overflow-hidden">{{ $title }}</h5>
                    <a href="{{ $link }}">
                        <button type="button" class="btn btn-success">View</button>
                    </a>
                </div>
                @endforeach
            @endforeach
        </section>
    @endif
@endsection
