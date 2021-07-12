<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('게시글 목록') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container mt-5">
                        <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" href="{{ route('dashboard')}}">대쉬보드</a>
                       @auth
                       <a href="/posts/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">게시글작성</a>
                       @endauth
                       <ul class="list-group mt-6">
                           @foreach($posts as $post)
                               <li class="list-group-item">
                                   <a class="text-purple-700 text-opacity-100" href="{{ route('posts.show',['id'=>$post->id,'page'=>$posts->currentPage()]) }}"> 제목 : {{$post->title }}</a>
                                   <div>
                                       {{-- Content: {{ $post->content }} --}}
                                   </div>
                                   <div>
                                       <div class="float-left" >작성자 : {{ $post->user_id }}</div>
                                       <div class="float-right bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $post->viewers->count() }}</div>
                                   </div>
                                   
                                   <div>
                                       <br>
                                        작성일 :{{ $post->created_at->diffForHumans(Carbon\Carbon::now()) }}
                                   </div>
                                   <hr>
                               </li>
                           @endforeach
                         </ul>
                   
                         <div>
                             {{ $posts->links() }}
                         </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
