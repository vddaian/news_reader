@extends('layouts.home_layout')
@section('title', 'Home')
@section('content')
    @if (isset($data['url']))
{{--         <section class="col-6 my-3">
            <form action="{{ route('newsp.update', $data['newspaper']) }}" class="form-inline w-50" method="POST">
                <h4 class="text-decoration-underline">Update Newspaper</h2>
                    <div class="form-group my-2 d-flex justify-content-center">
                        <input type="text" class="form-control" name="url" id="url"
                            value="{{ $data['url']->original['data'][0]['url'] }}">
                        @method('put');
                        @csrf
                        <input type="hidden" name="id" value {{ $data['newspaper'] }}>
                        <button type="submit" class="btn btn-warning mx-2">Update</button>
                    </div>
            </form>
        </section> --}}
    @endif
    @if (isset($data['articles']))
        <section class="container-xl h-75 bg-light my-4 overflow-auto rounded">
            @foreach ($data['articles']->original['data'] as $key => $article)
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
