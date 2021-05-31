@extends('layouts.admin')

@section('pageTitle')
Boolpress-Admin
@endsection

@section('content')
    <a href="{{route('admin.posts.create')}}"><button type="button" class="btn btn-success mb-5">Aggiungi Post</button></a>
         
         <ul class="list-group">
         @foreach ($posts as $post)

            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>
                    <a href="{{ route('admin.posts.show', [ 'post' => $post->id]) }}"> <h2>{{$post->title}}</h2> </a>
                    <small class="badge">{{$post->date}}</small>
                </span>
                <span class="badge badge-primary badge-pill">{{$post->public}}</span>
            </li>
            <hr>
            @endforeach

        </ul>
          


@endsection
