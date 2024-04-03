<?php

namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\CreateFolder;

class FolderController extends Controller
{
    public function showcreateForm()  //FolderControllerの[showcreateForm]という処理：この場合中身が走る
    {
        return view('folders/create');
    }
    //引数のcreatefolderでバリデーション実装
    public function create(createFolder $request) //FolderControllerの[create]という処理：この場合中身が走る
    {

        // フォルダモデルのインスタンスを作成する:select*from folders;
        $folder = new Folder();
        // タイトルに入力値を代入する:insert into folders title values $request
        $folder->title = $request->title;
        // ユーザーに紐づけて保存実行
        Auth::user()->folders()->save($folder);
        //完了したら一覧画面に自動で遷移する記述
        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }
}
