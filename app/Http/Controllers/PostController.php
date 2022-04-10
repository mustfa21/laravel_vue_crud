<?php

namespace App\Http\Controllers;
use App\Model\Post;
use Illuminate\Http\Request;
use Validator;
class PostController extends Controller
{
    public function createpost(Request $request){
    $validatedData =
    Validator::make($request->all(),[
        'title' => 'required|min:3',
        'body' => 'required|min:3',

    ]);

        if($validatedData->fails()){
   return response()->json(['status'=>'error','errors'=>$validatedData->errors()]);
        }
        $post =new Post;
        $post ->title = $request ->title;
        $post ->body =$request ->body;
        $post ->save();
        return response()->json(['status'=>'success','data'=>$post]);


    }
    public function updatepost(Request $request,$postid){
        $validatedData =
        Validator::make($request->all(),[
            'title' => 'required|min:3',
            'body' => 'required|min:3',

        ]);

            if($validatedData->fails()){
       return response()->json(['status'=>'error','errors'=>$validatedData->errors()]);
            }
            $post =Post::find($postid);
            $post ->title = $request ->title;
            $post ->body =$request ->body;
            $post ->save();
            return response()->json(['status'=>'success','data'=>$post]);


        }
    public function getposts(){
        $posts =Post::all();
        return response()->json(['status'=>'success','data'=>$posts]);

    }
    public function deletepost($postid){
        $post =Post::find($postid);
       if( $post->delete()){
        return response()->json(['status'=>'success','data'=>$post]);
       }
    }
}
