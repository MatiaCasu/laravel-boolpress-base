@extends('layouts.admin')

@section('pageTitle')
{{$post->title}}
@endsection

@section('content')
    <ul>
        <li>{{$post->content}}</li>
        <li><img src="{{$post->image}}" alt=""></li>
        @if($post->tags->isNotEmpty())
        <li><h4>Tag</h4>
            <ul>
                @foreach ($post->tags as $tag)
                <li>{{ $tag->name }}</li>                     
                @endforeach
            </ul>    
        </li>
        @endif
    </ul>
    @if ($post->comments->isNotEmpty())
        <h5>Commenti</h5>
        <ul>
            @foreach ($post->comments as $comment)
                <li>
                    <h5>Autore Commento: {{$comment->author ? $comment->author : 'Anonimo'}}</h5>
                    <p>TestoCommento: {{$comment->content}}</p>
                </li>
            @endforeach
        </ul>
    @endif
        <a href="{{route('admin.posts.edit', ['post' => $post->id])}}"><button type="button" class="btn btn-success mt-3">Modifica</button></a>
        <form action="{{route('admin.posts.destroy', [ 'post' => $post->id ])}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-success mt-3">Elimina</button>
        </form>       
        <a href="{{route('admin.posts.index')}}"><button type="button" class="btn btn-success mt-3">Home</button></a>
@endsection
