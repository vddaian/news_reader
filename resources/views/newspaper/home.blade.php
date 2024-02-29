@extends('layouts.home_layout')
@section('title', 'Home')
@section('content')
    <div class="container-xxl m-0 p-0 row h-75">
        <section class="col-6 my-3 d-flex justify-content-center">
            <form action="{{ route('newsp.store') }}" method='POST' class="form-inline w-50">
                <h4>New newspaper</h2>
                    <div class="form-group my-2">
                        <label for="title" class="my-2">Title:</label>
                        <input class='form-control' type="text" name='title'>
                        <label for="url" class="my-2">URL:</label>
                        <input class='form-control' type="text" name='url'>
                        @csrf
                    </div>
                    <button type="submit" class="btn btn-success">Add</button>
            </form>
        </section>
        <section class="col-6 my-3 d-flex align-items-center flex-column bg-light rounded">
            @if (isset($newspapers))
                @foreach ($newspapers as $newspaper)
                    <div class="w-100 mx-2 mt-2 p-3 bg-white d-flex align-items-center justify-content-between rounded">
                        <h5>{{ $newspaper[0]->title }}</h5>
                        <div class="d-flex">
                            <form class="px-1" action="{{ route('newsp.show', $newspaper[0]->id) }}" method="get">
                                <button class="btn btn-success" type="submit">View</button>
                            </form>
                            <form class='px-1' action="">
                                @method('delete')
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="mt-4">There's no newspaper</p>
            @endIf
        </section>
    </div>
@endsection
