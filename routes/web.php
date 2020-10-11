<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Events\FormSubmmitted;
use App\Events\GetCoins;
use App\Models\Msg;
use App\Models\User;
use App\Http\Controllers\UserController;

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
// Route::get('/index',function(){
// 	$data['coins'] = User::where('id',5)->get()->first();
// 	return view('index',$data);
// });
// Route::get('/sender',function (){
// 	return view('send');
// });
// Route::get('/coins',function (){
// 	return view('test');
// });
// Route::get('/test1',function (){
// 	event(new GetCoins(20));
// 	return view('test1');
// });
// Route::get('/test',function (){
// 	$d = User::where('id',5)->get()->first();
// 	$d->coins = $d->coins+10;
// 	$d->update();
// 	event(new FormSubmmitted($d->coins));
// });
// Route::post('/send',function (Request $req){
// 	$data = Msg::where('id',10)->get()->first();
// 	$text = json_encode($data);
// 	event(new FormSubmmitted($text));
// });
Route::view('/login', 'layouts.login');
Route::view('/signup','layouts.signup');
Route::post('/sendMessage',[UserController::class , 'sendMessage']);
Route::post('/signup_sub',[UserController::class , 'signup_sub']);
Route::post('/login_sub',[UserController::class , 'login_sub']);
Route::get('/logout',[UserController::class , 'logout']);
Route::group(['middleware'=>['checkSession','LastSeenUserActivity']],function(){
	Route::get('/dashboard',[UserController::class , 'index']);
	Route::get('/getMessage/{id}',[UserController::class,'getMessage']);
	Route::post('/sendmessage',[UserController::class , 'sendmessage']);
});