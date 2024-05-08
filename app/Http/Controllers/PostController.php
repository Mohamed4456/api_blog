<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use app\Http\Resources\Post as PostResource;
use Illuminate\Support\Facades\Validator;
use app\Models\Post;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=Post::all();
        return $this->sendResponse(PostResource::collection($posts),
        'Posts recieved Success ' );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        $input=$request->all();
        $validator= Validator::make($input,[
            'title'=>'required',
            'description'=>'required',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendError('validate errors', $validator->errors());
        }
        $post = Post::create($input);
        return $this->sendResponse($post, 'Post Created Success ' );


    }


    public function show($id)
    {
        $post =Post::find($id);

        return $this->sendResponse(new PostResource($post),
        'Posts retrived Success ' );
    
    }



    public function update(Request $request, Post $post)
    {
        $input=$request->all();
        $validator= Validator::make($input,[
            'title'=>'required',
            'description'=>'required',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendError('validate errors', $validator->errors());
        }

        $post->title = $input['title'];
        $post->description = $input['description'];
        $post->save();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Post $post)
    {
        $post->delete();
        return $this->sendResponse(new PostResource($post),
        'Posts Deleted Success ' );
    }
}
