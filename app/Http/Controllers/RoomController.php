<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoomController extends Controller {
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
				$arr['roomToken'] = Hash::make($roomId[0]->id.'3'.$roomName.'3'.$userId.'0'.$userEmail[0]->email.'6');
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
} 
