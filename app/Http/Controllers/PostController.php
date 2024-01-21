<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function index(Post $post)
    {
        //phpinfo();
        //return view('posts.index')->with(['posts'=> $post->getPaginateByLimit(5)]);
        //blade内で使う変数'posts'と設定。'posts'の中身にgetを使い、インスタンス化した$postを代入。
        
        //クライアントインスタンス作成
        $client = new \GuzzleHttp\Client();    
        
        //GET通信するURL、以下のURLにアクセストークを用いてGET通信することで最新の質問データを取得することができる
        $url = 'https://teratail.com/api/v1/questions';
        
        //リクスト送信と返却データの取得、Bearerトークンにアクセストークンをしてして認証を行う
        $response = $client->request(
            'GET',
            $url,
            ['Bearer' => config('services.teratail.token')]
        );
        
        //API通信で取得したデータはjson形式なのでphpファイルに対応した連想配列にデコードする
        $questions = json_decode($response->getBody(),true);
        
        //index bladeに取得したデータを渡す
        return view('posts.index')->with([
            'posts' => $post->getPaginateByLimit(),
            'questions' => $questions['questions'],
            ]);
    }
    
    public function show(Post $post)
    {
        return view('posts.show')->with(['post' => $post]);
    }
    
    public function create(Category $category)
    {
        return view('posts.create')->with(['categories'=>$category->get()]);
    }
    
    public function store(PostRequest $request, Post $post)
    {
         $input = $request['post'];
         $post->fill($input)->save();
         return redirect('/posts/' . $post->id);
        //dd($request->all());
    }
    
    public function edit(Post $post)
    {
        return view('posts.edit')->with(['post'=>$post]);
    }
    
    public function update(PostRequest $request, Post $post)
    {
        $input_post = $request['post'];
        $post->fill($input_post)->save();
        return redirect('/posts/' . $post->id);
    }
    
    public function delete(Post $post){
        $post->delete();
        return redirect('/');
    }
}
