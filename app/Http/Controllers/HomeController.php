<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Redirect;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    //    $this->middleware('auth'); // 비로그인 시 로그인 화면으로 이동
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        return view('index');
    }
    
    // board
    public function getBoardCreate()
    {
		return view('board/create');
    }
    public function postBoardCreate(Request $request)
    {
		if(Auth::check() && $request->input('title') && $request->input('content')){
			$user = Auth::user();
			
			$id = DB::table('board')->insertGetId([
				'title'=>$request->input('title'),
				'content'=>$request->input('content'),
				'user_id'=>$user->id,
				'user_name'=>$user->name
			]);
		}
		return Redirect('board/'.$id);
    }
    
    public function getBoardRead($id)
    {
		$article=DB::table('board')->where('id', $id)->first();
		$data=array('article'=>$article);
		return view('board/read', $data);
    }
    
    public function getBoardList()
    {
		$list=DB::table('board')->select('id','title','user_name','created_at')->get();
		$data=array('list'=>$list);
		return view('board/list', $data);  
    }
    
    public function getBoardDelete($id)
    {
		$article=DB::table('board')->where('id', $id)->select('id','title')->first();
		$data=array('article'=>$article);
		return view('board/delete', $data);
    }
    public function postBoardDelete($id)
    {
	    DB::table('board')->where('id', $id)->delete();
		return Redirect('board');
    }
    
    public function getBoardUpdate($id)
    {
		$article=DB::table('board')->where('id', $id)->first();
		$data=array('article'=>$article);
		return view('board/create', $data);
    }
    public function postBoardUpdate(Request $request,$id)
    {
		if(Auth::check() && $request->input('title') && $request->input('content')){
			DB::table('board')->where('id', $id)->update([
				'title'=>$request->input('title'),
				'content'=>$request->input('content'),
			]);
			DB::update('update '.DB::getTablePrefix().'board set updated_at=NOW() where id='.$id);
		}
		return Redirect('board/'.$id);
    }
}
