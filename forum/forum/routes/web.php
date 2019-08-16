<?php

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
use Naux\Mail\SendCloudTemplate;
use App\User;


Route::get('/', 'QuestionController@index');
//根据Topic获取question
Route::get('/topic/{id}', 'QuestionController@topic');

//Route::resource('/questions','QuestionController',[
 //   'names' => [
 //       'create' => 'question.create',
 //       'show' => 'question.show'
 //   ]
//]);
Route::post('/questions', 'QuestionController@store');
Route::get('/questions', 'QuestionController@index');
Route::get('/questions/create', 'QuestionController@create')->middleware('authority');
Route::get('/question/show/{id}', 'QuestionController@show');

Route::PATCH('/questions/{id}', 'QuestionController@update');
Route::get('/questions/{id}', 'QuestionController@show');
Route::delete('/questions/{id}', 'QuestionController@destroy');
Route::get('/questions/{id}/edit', 'QuestionController@edit');


Route::post('questions/{question}/answer', 'AnswersController@store');

Route::get('question/{question}/follow', 'QuestionFollowController@follow');

/*
 * 用户登录注册有关
 */

//激活用户
Route::get('email/verify/{token}',['as' => 'email.verify', 'uses' => 'EmailController@verify']);

Route::get('register/login/out', function () {
    //flash('你已注册成功，请激活邮箱再次登录。', 'success');
    return view('registerLoginOut');
});

//和用户有关的各种操作
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//notification关注通知
Route::get('notifications', 'NotificationController@index');


//搜索
Route::post('search', 'QuestionController@search');
Route::post('/search/degree', 'QuestionController@searchDegree');


//用户使用面板
Route::get('/user', 'UserController@store');
Route::get('/users/{id}', 'UserController@store');
Route::get('/user/now', 'UserController@nowLogin');
Route::get('/user/list', 'UserController@userList');

//和查看私信Message有关
Route::get('/messages/{id}', 'MessagesController@readMessage')->middleware('auth');
Route::get('/messagesTo/{id}', 'MessagesController@readMessageTo')->middleware('auth');



//分页路由
Route::paginate('questions', "QuestionController@index");
Route::paginate('/', "QuestionController@index");


//关注回显
Route::get('/user/followed','UserController@followedList');


//权限设置
Route::get('/authority/editors/{id}', 'AuthorityController@setEditorALink')->middleware('super');
Route::get('/authority/manager/{id}', 'AuthorityController@setManagerALink')->middleware('super');

