@extends('layouts.home_layout');
@section('title', 'Home')
@section('content')
    <section>
        <form action="{{route('newsp.store')}}" method='POST'>
            <div class="form-control">
                <input type="text" name='url-newspaper'>
            </div>
            <button class="btn btn-success"></button>
        </form>
    </section>
    <section>
        @if($newspaper){
            
        }
    </section>
@endsection