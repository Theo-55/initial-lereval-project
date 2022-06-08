<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use Spatie\YamlFrontMatter\YamlFrontMatter;

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
    return view('posts', [
        'posts' => Post::all()
    ]);

});//testing github setup with a comment

Route::get('posts/{post}', function ($slug) {

    return view('post', [ 
        'post' => Post::find($slug) //this calls to the class of post thats responsible for finding the correct view
    ]);

})->where('post', '[A-z]+'); //where allows you to put any acceptable characters within the url that are checked

