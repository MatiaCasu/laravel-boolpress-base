<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        ul{
            list-style: none;
            padding: 0;
        }
    </style>
</head>
<body>
    <h1>Boolpress</h1>
    @foreach ($posts as $post)
        <ul>
            <li><h2>Titolo: {{$post->title}}</h2></li>
            <li>Testo: {{$post->content}}</li>
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
        <hr>
    @endforeach
</body>
</html>