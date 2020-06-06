<?php

use App\Issue_Comment;
use App\Repository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

Route::group(['middleware' => ['auth']], function (){
    Route::resource('repositories','RepositoryController');
    Route::get('/explore','ExploreController@index');
    Route::get('/starred-repositories', function (){
        $user = User::find(Auth::id());
        return view('starred_repositories', [
            'repositories' => $user->starredRepositories
        ]);
    });
    Route::get('/followers', function (){
        // todo refactor
        $user = User::find(Auth::id());
        $followers = [];
        foreach ($user->followers as $follower){
            array_push($followers, User::find($follower->follower_id));
        }

        return view('followers', ['followers' => $followers]);
    });
    Route::get('/following', function (){
        //todo refactor
        $user = User::find(Auth::id());
        $followees = [];
        foreach ($user->followees as $followee){
            array_push($followees, User::find($followee->followee_id));
        }

        return view('/following', ['followees' => $followees]);
    });
    Route::resource('repositories.issues', 'IssueController')->shallow()->only(['index', 'create', 'store', 'show', 'update']);
    Route::post('/issue-comments', function (){
        request()->validate(['body' => 'required']);
        Issue_Comment::create([
            'user_id' => Auth::id(),
            'issue_id'=> request('issue_id'),
            'body' => request('body')
        ]);
        return redirect("/issues/". request('issue_id'));
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home'); //todo fix
