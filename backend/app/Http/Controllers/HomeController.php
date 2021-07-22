<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        //ログインユーザを取得
        $user = Auth::user();
        //ログインユーザに関連するフォルダを取得する
        $folder = $user->folders()->first();
        //フォルダが見つからない場合ホームページを表示
        if(is_null($folder)){
            return view('home');
        }
        //フォルダがあればタスク一覧を表示
        
        return redirect()->route('tasks.index',[
            'folder' => $folder->id,
        ]);
    }
}
