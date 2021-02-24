<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use App\Models\Auth;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create(PostRequest $req) 
    {        
        $post = new Post();
        $datePost = $post->where('title', '=', $req->input('title'))->get('id');

        $auth = new Auth();
        $dateAdmin = $auth->where('api_token', '=', $req->input('token'))->where('role', '=', 'admin')->get();
        
		if(empty($dateAdmin[0])){
            return 'Токен администратора указан неверно';
        } else {
            if(empty($datePost[0])){
                $post->title = $req->input('title');
                $post->anons = $req->input('anons');
                $post->text = $req->input('text');
                $post->tags = $req->input('tags');
                $post->image = $req->input('image');
                
                $post->save();
                $datePost = Post::where('title', '=', $req->input('title'))->first();                

                return "Пост создан успешно, его уникальный ид: {$datePost->id}";
            } else {      
                return 'Пост с таким тайтлом уже существует';
            }
        }
    }

    public function edit($id, PostRequest $req) 
    {        
        $post = new Post();
        $datePost = $post->where('id', '=', $id)->get();

        $auth = new Auth();
        $dateAdmin = $auth->where('api_token', '=', $req->input('token'))->where('role', '=', 'admin')->get();
        
		if(empty($dateAdmin[0])){
            return 'Токен администратора указан неверно';
        } else {
            if(empty($datePost[0])){
                return 'Пост с таким ид не найден';
            } else {      
                $post = Post::find($id);
                $post->title = $req->input('title');
                $post->anons = $req->input('anons');
                $post->text = $req->input('text');
                $post->tags = $req->input('tags');
                $post->image = $req->input('image');
                
                $post->save();
                $datePost = Post::where('title', '=', $req->input('title'))->first();     

                return "Пост с ид {$datePost->id} изменён успешно";
            }
        }
    }
    
    public function delete($id, Request $req) 
    {        
        $post = new Post();
        $datePost = $post->where('id', '=', $id)->get();

        $auth = new Auth();
        $dateAdmin = $auth->where('api_token', '=', $req->input('token'))->where('role', '=', 'admin')->get();
        
		if(empty($dateAdmin[0])){
            return 'Токен администратора указан неверно';
        } else {
            if(empty($datePost[0])){
                return 'Пост с таким ид не найден';
            } else {      
                $post = Post::find($id);
                $post->id = $id; 
                $post->delete(); 

                return "Пост с ид {$id} удалён успешно";
            }
        }
    }
    public function allPosts(){
        $post = new Post();
        $post = $post->get();
        dd($post);
    }
    public function find($id){
        $post = new Post();
        $post = $post->where('id', '=', $id)->get();
        dd($post);
    }
    public function comment($id, CommentRequest $req){
        $comment = new Comment();
        $comment->post_id = $id;
        $comment->author = $req->input('author');
        $comment->comment = $req->input('comment');
        $comment->save();
        return "Коментарий к посту {$id} добавлен";
    }
    public function deleteComment($id, $id2, Request $req){        
        $post = new Post();
        $datePost = $post->where('id', '=', $id)->get();

        $comment = new Comment();
        $dateComment = $comment->where('id', '=', $id2)->get();

        $auth = new Auth();
        $dateAdmin = $auth->where('api_token', '=', $req->input('token'))->where('role', '=', 'admin')->get();
        
		if(empty($dateAdmin[0])){
            return 'Токен администратора указан неверно';
        } else {
            if(empty($datePost[0])){
                return "Пост с ид {$id} не существует";
            } else {
                if(empty($dateComment[0])){
                    return 'Комментарий с таким ид не найден';
                } else {      
                    $comment = Comment::find($id);
                    $comment->id = $id; 
                    $comment->delete(); 

                    return "Комментарий с ид {$id2} удалён успешно";
                }
            }
        }
    }
    public function findTag($tag){
        $post = new Post();
        $post = $post->where('tags', 'like', "%{$tag}%")->get();
        dd($post);
    }
}
