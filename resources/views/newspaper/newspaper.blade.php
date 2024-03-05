@extends('layouts.home_layout')
@section('title', 'Home')
@section('content')
    <section class="container-xxl h-75 my-4 rounded d-flex">

        <div class="w-75 d-flex">
            @if (isset($data['valid_articles']))
                <div class="w-50">
                    <h3 class="m-2">Articulos validos</h3>
                    <div class="h-100 m-2 overflow-auto border bg-light rounded">
                        @foreach ($data['valid_articles'] as $key => $article)
                            @foreach ($article as $title => $link)
                                <div class="d-flex justify-content-between align-items-center m-2 p-2 rounded bg-white">
                                    <h5 class="w-75 overflow-hidden">{{ $title }}</h5>
                                    <a href="{{ $link }}">
                                        <button type="button" class="btn btn-success">View</button>
                                    </a>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            @endif
            @if (isset($data['invalid_articles']))
                <div class="w-50">
                    <h3 class="m-2">Articulos no validos</h3>
                    <div class="h-100 m-2 overflow-auto border bg-light rounded">
                        @foreach ($data['invalid_articles'] as $key => $article)
                            @foreach ($article as $title => $link)
                                <div class="d-flex justify-content-between align-items-center m-2 p-2 rounded bg-white">
                                    <h5 class="w-75 overflow-hidden">{{ $title }}</h5>
                                    <a href="{{ $link }}">
                                        <button type="button" class="btn btn-success">View</button>
                                    </a>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        @if (isset($data['range']))
            <div class="w-25 d-flex flex-column justify-content-center align-items-center">
                <h3>Precisión</h3>
                <div class=" p-3 bg-light rounded border">
                    <p style="font-size:40px;">{{ $data['range'] }}%</p>
                </div>
                
            </div>
        @endif
    </section>



@endsection
