<?php

use App\Http\Controllers\GitHubAuth;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::get('/show',function() {
    $name = '홍길동';
    $age = 20;
    //return view('show',['name'=>$name],['age'=>10]);
    return view('show',compact('name','age'));
});

Route::get('/test4',[hello::class,'index']);

Route::get('/posts/create',[PostsController::class,'create'])->middleware(['auth']);


Route::post('/posts/store',[PostsController::class,'store'])->name('posts.store')/*->middleware(auth())*/; 

Route::get('/posts/index',[PostsController::class,'index'])->name('posts.index'); 
Route::get('/posts/index/mypost',[PostsController::class,'index2'])->name('posts.index2'); 
Route::get('/posts/show/{id}',[PostsController::class,'show'])->name('posts.show'); 
// Route::get('post/create','PostsController@create');

Route::get('/posts/{post}',[PostsController::class,'edit'])->name('posts.edit');
Route::put('/posts/{id}',[PostsController::class,'update'])->name('posts.update');
Route::delete('/posts/{id}',[PostsController::class,'destroy'])->name('posts.delete');
Route::get('/github/login',[GitHubAuth::class,'redirect'])->name('github.login');
Route::get('/github/callback',[GitHubAuth::class,'callback']);
require __DIR__.'/auth.php';
