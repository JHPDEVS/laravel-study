<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        legend {
            padding-top: 50px;
        }
    </style>
      <!-- Scripts -->
<!-- 합쳐지고 최소화된 최신 CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- 부가적인 테마 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<!-- 합쳐지고 최소화된 최신 자바스크립트 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</head>
<body>
 <div class="container">
<form action="{{ route('posts.update',['id'=>$post->id,'page'=>$page]) }}" method="post" enctype="multipart/form-data">
  @csrf
    @method('put')
    <fieldset>
    <legend>게시글 수정</legend>
    {{-- method spoofing --}}
    <div class="form-group">
        <label for="title">제목</label>
        <input type="text" name="title" class="form-control" id="title" placeholder="제목을 입력하세요" value="{{ old('title') ? old('title') : $post->title}}">

        @error('title')
        <div>
            {{ $message }}
        </div>
    @enderror
      </div>
      <div class="form-group">
        <label for="title">내용</label>
        <textarea name="content" class="form-control" id="content" cols="30" rows="10" placeholder="내용을 입력해주세요">{{ old('content') ? old('content') : $post->content}}</textarea>
        @error('content')
        <div> {{ $message }}</div>
        @enderror
      </div>
      <div class="from-group">
          <img class="thumbnail-image" width="20%" src="{{ $post->imagePath() }}" alt="">
      </div>
      <div class="form-group">
        <label for="image">이미지</label>
        <input type="file" id="file" name="imageFile">
        @error('imageFile')
        <div> {{ $message }}</div>
        @enderror
      </div>

    <input type="submit" class="btn btn-primary" value="제출">  
    </fieldset>
    </form>
</div>
</body>
</html>