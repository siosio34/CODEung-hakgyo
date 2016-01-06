<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class RoomController extends Controller {

    public function __construct(){
        $this->middleware('auth'); // Make only user who signed in can access ...by MANAPIE
    }
	
	public function getRoomList() {
		$rooms=DB::table('rooms')->select('id','name','password','type','tag','description','user_limit')->get();
		$data=array('rooms'=>$rooms);
		return view('rooms/list', $data);
	} // by MANAPIE
	
	public function getRoomCreate() {
		return view('rooms/create');
	} // by MANAPIE
	
	public function postRoomCreate(Request $request) {
		if(Auth::check() && $request->input('name')){
			$id = DB::table('rooms')->insertGetId([
				'name'=>$request->input('name'),
				'type'=>$request->input('type'),
				'tag'=>preg_replace('/\s+/','',$request->input('tag')),
				'description'=>$request->input('description'),
				'user_limit'=>$request->input('limit'),
				'master_id'=>Auth::user()->id,
				'password'=>bcrypt($request->input('password')),
			]);
			if($request->input('password')){
				DB::table('rooms')->where('id',$id)->update([
					'password'=>bcrypt($request->input('password')),
				]);
			}
			
			DB::table('rooms')->where('id',$id)->update([
				'token'=>crypt($id.'3'.$request->input('name').'3'.Auth::user()->id.'0'.Auth::user()->email.'6'), // by akakakakakaa
			]);
			return Redirect('room/'.$id);
		}
	} // by MANAPIE
	
	public function getRoomRead($id) {
		$room=DB::table('rooms')->where('id',$id)->first();
		$data=array('room'=>$room);
		return view('rooms/read', $data);
	} // by MANAPIE
	
	public function getRoomCode($id) {
		$room=DB::table('rooms')->select('code')->where('id',$id)->first();
		$data=array('room'=>$room);
		return view('rooms/code', $data);
	} // by MANAPIE
	
	public function postRoomCode(Request $request,$id) {
		DB::table('rooms')->where('id',$id)->update([
			'code'=>$request->input('code'),
		]);
	} // by MANAPIE


	/*
	public function createRoom(Request $request) {
		$roomName = $request->input('roomName');
		$userId = $request->input('userId');
		$arr = array('roomToken' => NULL, 'isMaster' => NULL);
		try {
			$roomId = DB::select('select id from codeung_rooms where name = ? and master_id = ?', [$roomName, $userId]);
			if(!isset($roomId[0]->id)) {
				DB::insert('insert into codeung_rooms (name, master_id) values (?, ?)', [$roomName, $userId]);
				$roomId = DB::select('select id from codeung_rooms where name = ? and  master_id = ?', [$roomName, $userId]);
				$userEmail = DB::select('select email from codeung_users where id = ?', [$userId]);
				$arr['roomToken'] = bcrypt($roomId[0]->id.'3'.$roomName.'3'.$userId.'0'.$userEmail[0]->email.'6');
				DB::update('update codeung_rooms set token = ? where id = ?', [$arr['roomToken'], $roomId[0]->id]);
				$arr['isMaster'] = true;
				return json_encode($arr);
			}
			else
				return 'already exists';
		} catch(\Exception $e) {
		}
	}

	public function enterRoom(Request $request) {
		$roomId = $request->input('roomId');
		$userId = $request->input('userId');
		$arr = array('roomToken' => NULL, 'isMaster' => NULL);
		try {
			$token = DB::select('select token from codeung_rooms where id = ? and master_id = ?', [$roomId, $userId]);
			if(isset($token[0]->token)) {
                                $arr['roomToken'] = $token[0]->token;
				$arr['isMaster'] = true;
			}
                        else {
                                $token = DB::select('select token from codeung_rooms where id = ?', [$roomId]);
                                $arr['roomToken'] = $token[0]->token;
				$arr['isMaster'] = false;
			}
			return  json_encode($arr);
		} catch(\Exception $e) {
		}
	}
	*/
} 
