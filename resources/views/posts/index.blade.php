<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>    
        <x-slot name="header">
                Index
            <meta charset="utf-8">
            <title>Blog</title>
            <!-- Fonts -->
            <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        </x-slot>
        <body>
            <h1>Blog Name</h1>
            <a href="posts/create">create</a>
            <div class = 'posts'>
                @foreach($posts as $post)
                <div class = 'post'>
                    <h2 class = 'title'><a href='posts/{{$post->id}}'>{{$post->title}}</a></h2>
                    <p class = 'body'>{{$post->body}}</p>
                    <form action="/posts/{{$post->id}}" id="form_{{$post->id}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="deletePost({{$post->id}})">delete</button>
                    </form>
                    <script>
                        function deletePost(id){
                            'use strict'
                            
                            if(confirm('削除すると復元できません。\n本当に削除しますか？')){
                                document.getElementById(`form_${id}`).submit();    //バッククォーテーションの中で${変数名}とすることで文字列の中で変数を扱うことができる
                            }
                        }
                    </script>
                </div>
                @endforeach
            </div>
            <div class = 'paginate'>
                {{$posts->links()}}
            </div>
            <div>
                <p>
                    ログインユーザー_{{Auth::user()->name}}
                </p>
            </div>
            <div>
                @foreach($questions as $question)
                    <div><a href="https://teratail.com/questions/{{$question['id']}}">{{$question['title']}}</a></div>
                @endforeach
            </div>
        </body>
    </x-app-layout>
</html>