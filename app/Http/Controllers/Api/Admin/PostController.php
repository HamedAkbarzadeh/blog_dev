<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $v = verta();
        $post = Post::create([
           'title' => $request->title,
           'description' => $request->description,
           'categories' => $request->categories,
           'image' => $request->image,
            'like' => $request->like,
            'date' => $v->formatJalaliDate(), // 23:26:35,
        ]);
        return response()->json([
            'post' => $post,
            'massage' => 'successful inserted',
        ]);
        return response()->json([
            'massage' => 'failed to inserted',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $result = $post->update($request->all());
        if($result){
            return response([
                'post_information' => $post,
                'message' => 'success'
            ]);
        }else {
           return response([
               'message' => 'ویرایش پست با خطا مواجه شد لطفا دوباره تلاش کنید',
               'status' => 'error'
           ]);
       }

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $result = $post->delete();

        if($result){
            return response()->json([
                'msg' => 'successful deleted',
             ]);
        }
        else{
            return response()->json([
                'massage' => 'failed to deleted',
            ]);
        }
    }

    public function search($title){
        return Post::where('title' , 'like' , '%'.$title.'%')->get();
    }
}
