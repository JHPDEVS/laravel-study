<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class PostsController extends Controller
{
    public function __construct() {
        $this->middleware(['auth'])->except(['index','show','edit','update']);
    }

    public function create() {
        return view('posts.create');

    }

    public function store(Request $request) {
     //   $request->input['title'];
       // $request->input['content'];
       // dd($request);
        $title = $request->title;
        $content = $request->content;

        $request->validate([
            'title' => 'required|min:3',
            'content' => 'required',
            'imageFile' =>  'image | max:50000000000' // 필수는 아니나 이미지 파일이어야함
        ]);

      //  dd($title);

        /*
            File 처리
            내가 원하는 파일 시스템 상의 위치에 원하는 이름으로
            파일을 저장하고
            그 파일 이름을 컬럼에 설정
            $post->image = $filename
        */
        $post = new Post();
        $post->title = $title;
        $post->content = $content;
        if($request->file('imageFile')) {
            $post->image = $this->uploadPostImage($request);
          }
        $post->user_id = Auth::user()->id;
        $post->save();

        // 결과 뷰를 리턴반화해준다
        return redirect('/posts/index');
        // $posts = Post::latest()->Paginate(2);
        // return view('posts.index',compact('posts'));
    }

    public function edit(Request $request,Post $post) {
        //$post = Post::find($id);
        //$post = Post::where('id',$id)->first();
        $page = $request->page;
        return view('posts.edit',compact(['post','page']));
    }

    public function update(Request $request, $id) {
        // 게시글을 데이터베이스에서 수정
        // 이미지 파일 수정 , 파일시스템에서

        $request->validate([
            'title' => 'required|min:3',
            'content' => 'required',
            'imageFile' =>  'image | max:50000000000' // 필수는 아니나 이미지 파일이어야함
        ]);
        $page= $request->page;
        $post = Post::find($id);

        // if($request->user()->cannot('update',$post)) {
        //     abort(503);
        // }

        if(empty(Auth::user()->id)) {
            abort(403);
        } else {
            if(auth()->user()->id != $post->user_id) {
                abort(503);
            }
        }
        // 이미지 파일 수정 . 파일시스템에서
        if($request->file('imageFile')) {
            $imagePath = 'public/images/'.$post->image;
            Storage::delete($imagePath);
            $post->image = $this->uploadPostImage($request);
        }
        $post->title=$request->title;
        $post->content=$request->content;
        $post->save();
        return redirect()->route('posts.show',compact(['id','page']));
    }

    public function destroy(Request $request,$id) {
        // 게시글을 데이터베이스에서 삭제
        // 파일 시스템에서 이미지 파일 삭제
        $post = Post::findOrFail($id);
        $image = $post->image;
        $page = $request->page;
        $user_id = auth()->user()->id;
        if($request->user()->cannot('delete',$post)) {
            abort(503);
        }
        if($user_id) {
            if(auth()->user()->id != $post->user_id) {
                abort(403);
            }
        } else {
            abort(404);
        }

        if($image!=null) {
            $imagePath = 'public/images/'.$image;
            Storage::delete($imagePath);
        }
        $post->delete();
        
        return redirect()->route('posts.index',compact('page'));
    }

    protected function uploadPostImage(Request $request) {
        $name = $request->file('imageFile')->getClientOriginalName();
        $request->file('imageFile')->storeAs('images',$name);
        $extension = $request->file('imageFile')->extension();
        $nameWithoutExtension = Str::of($name)->basename('.'.$extension);
        $fileName = $nameWithoutExtension.'_'.time().'.'.$extension;
        $request->file('imageFile')->storeAs('public/images',$fileName);
        // $post->image = $fileName;
        return $fileName;
    }
    public function show(Request $request,$id) {
        //dd($request->page);
        $page = $request->page;
        $post = Post::find($id);


        /*
        이 글을 조회한 사용자들 중에, 현재
        로그인한 사용자가 포함되어있는지를 체크하고
        포함되어 있지않으면 추가
        포함되어있으면 다음 단계로 넘어감
        */
        if(Auth::user()!= null && $post->viewers->contains(Auth::user()) == false) {
            $post->viewers()->attach(Auth::user()->id);
        }
        $post->count += 1;
        $post->save();
        return view('posts.show',compact('post','page'));
    }

    public function index() {
    //    $posts = Post::orderBy('created_at','desc')->get();
    //    $posts = Post::latest()->get();

        $posts = Post::latest()->Paginate(5);
        return view('posts.index',compact('posts'));
    }
    
    public function index2() {
        //    $posts = Post::orderBy('created_at','desc')->get();
        //    $posts = Post::latest()->get();
    
          //  $posts =  User::find(Auth::user()->id)->posts()->latest()->Paginate(6);
            $posts =  User::find(Auth::user()->id)->posts()->orderBy('created_at','desc')->Paginate(6);
            return view('posts.index',compact('posts'));
        }
}
