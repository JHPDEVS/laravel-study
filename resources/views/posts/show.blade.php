
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        legend {
            padding-top: 50px;
        }

        .inline-block {
            display: inline-block;
        }
    </style>
    
      <!-- Scripts -->
<!-- 합쳐지고 최소화된 최신 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<?php
Carbon\Carbon::setLocale('ko'); 
?>

</head>
<body>
 <div class="container mt-5">
     echo {{ $page }}
     <div class="m-5">
        <a href="{{ route('posts.index')}}/?page={{ $page }}">목록보기</a>
     </div>
    <div class="from-group">
        <label for="title">Title</label>
        <input type="text" readonly name="title" class="form-control" id="title" value= "{{ $post->title }}">
    </div>

    <div class="from-group">
        <label for="title">Content</label>
        <div type="text" readonly name="content" class="form-control" id="content"> {!! $post->content !!}</div>
    </div>
    <div class="from-group">
        <label for="image">Post Image</label>
        <div class="my-6 mx-3 w-3/12" style="width: 20%">
            <img class="form-control" src="\storage\images\{{ $post->image ?? 'no_img.jpg'}}" alt="">
        </div>
    </div>
    <div class="from-group">
        <label for="title">등록일</label>
        <input type="text" readonly name="title" class="form-control" id="title" value= "{{ $post->created_at->diffForHumans(Carbon\Carbon::now()) }}">
    </div>

    <div class="from-group">
        <label for="title">수정일</label>
        <input type="text" readonly name="title" class="form-control" id="title" value= "{{ $post->updated_at }}">
    </div>

    <div class="from-group">
        <label for="title">작성자</label>
        <input type="text" readonly name="title" class="form-control"  value= {{ $post->user->name }}>
    </div>
    @auth
    @if(Auth::user()->id== $post->user->id)
    <div class="inline-block">
    <div class="flex mt-2">
        <a class="btn btn-warning" href={{ route('posts.edit',['post'=>$post->id,'page'=>$page]) }}>수정</a>
    </div>
    <div>
    <form action="{{ route('posts.delete',['id'=>$post->id,'page'=>$page]) }}" method="post">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger">삭제</button>
        </form>
    </div>
    @endif
    @endauth
    <div>
        <a class="btn btn-primary" href="{{ route('posts.index')}}/?page={{ $page }}">목록보기</a>
    </div>
</div>
</div>
</body>
</html>