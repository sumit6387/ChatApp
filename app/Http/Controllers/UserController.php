<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Validator;
use Session;
use App\Events\FetcgMessage;
use Illuminate\Http\Request;
class UserController extends Controller
{
    public function index(){
    	$id = Session::get('id');
    	$data['users'] = User::where('id','!=',$id)->get();
    	return view('layouts.dashboard',$data);
    }

    public function getMessage($id){
        $user_data = Message::where('send_by',$id)->where('user_id',Session::get('id'))->orwhere('send_by',Session::get('id'))->where('user_id',$id)->get();
        $user_info = User::where('id',$id)->get()->first();
        $data = Message::where('user_id',Session::get('id'))->update(['status'=>1]);
        echo json_encode(array('data'=>$user_data , 'user'=>$user_info));
    }

    public function sendMessage(Request $request){
        $new_msg = new Message();
        $new_msg->user_id = $request['recieve_id'];
        $new_msg->send_by = Session::get('id');
        $new_msg->msg = $request['msg'];
        $new_msg->status = 0;
        $new_msg->msg_time = $request['time'];
        $new_msg->save();
        $image = User::where('id',$request['recieve_id'])->get()->first()->images;
        $user_data = json_encode(array('user_id'=>$request['recieve_id'] , 'send_by'=>Session::get('id'),'msg'=>$request['msg'] , 'msg_time'=>$request['time'] , 'images'=>$image));
        event(new FetcgMessage($user_data));

    }
    
    public function signup_sub(Request $req){
    	$valid = Validator::make($req->all(),['name'=> 'required','mobile'=>'required', 'pass'=>'required']);
    	if($valid->passes()){
    		$num = User::where('mobile',$req['mobile'])->get()->first();
    		if(!$num){
	    		$num = rand(0,99);
	    		$data = new User();
	    		$data->name = $req['name'];
	    		$data->mobile = $req['mobile'];
	    		$data->password = $req['pass'];
	    		$data->images = "https://ui-avatars.com/api/?name=".$req['name'];
	    		$data->save();
	    		$arr = json_encode(array('status'=>'true','url'=>url('/login')));
	    	}
	    		else{
	    			$arr = json_encode(array('status'=>'false','msg'=>'Your Phone Number already Registerd.'));
	    		}
    	}else{
    		$arr = json_encode(array('status'=>'false','msg'=>$valid->errors()->all()));
    	}
    	echo $arr;
    }
    public function login_sub(Request $req){
    	$valid = Validator::make($req->all(),['mobile'=>'required', 'pass'=>'required']);
    	if($valid->passes()){
    		$data = User::where('mobile',$req['mobile'])->where('password',$req['pass'])->get()->first();
    		if($data){
    			Session::put('user_id',$req['mobile']);
    			Session::put('id',$data->id);
                Session::put('image',$data->images);
    			$arr = json_encode(array('status'=>'true','url'=>url('/dashboard')));
    		}else{
    			$arr = json_encode(array('status'=>'false','msg'=>'Enter valid credentials'));
    		}
    	}else{
    		$arr = json_encode(array('status'=>'false','msg'=>$valid->errors()->all()));
    	}
    	echo $arr;
    }
    public function logout(){
    	Session::put('user_id','');
    	return redirect(url('/login'));
    }
}
