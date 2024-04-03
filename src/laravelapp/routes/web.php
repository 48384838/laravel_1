<?php

//ログイン認証しないとルートの処理動かないよう全体を囲む
Route::group(['middleware' => 'auth'], function () {

    //入力フォーム画面を返却するルート
    Route::get('/comment', 'CommentController@showForm')->name('comment');
    //入力を受け付けるルート
    Route::post('/comment', 'CommentController@create');
    //入力送信後にリダイレクトする完了画面遷移のルート
    Route::get('/comment/thanks', 'CommentController@thanks')->name('comment.thanks');

    //getメソッドで/folders/createからFolderControllerという指示きたらshowCreateFormを走らせる→この流れをfolders.createと名付ける
    Route::get('/folders/create', 'FolderController@showCreateForm')->name('folders.create');
    Route::post('/folders/create', 'FolderController@create');

    Route::get('/', 'HomeController@index')->name('home');

    Route::group(['middleware' => 'can:view,folder'], function () {
        Route::get('/folders/{folder}/tasks', 'Taskcontroller@index')->name('tasks.index');

        //タスク作成機能ルーティング
        Route::get('/folders/{folder}/tasks/create', 'TaskController@showCreateForm')->name('tasks.create');
        Route::post('/folders/{folder}/tasks/create', 'TaskController@create');

        //タスク編集機能
        Route::get('/folders/{folder}/tasks/{task}/edit', 'TaskController@showEditForm')->name('tasks.edit');
        Route::post('/folders/{folder}/tasks/{task}/edit', 'TaskController@edit');
    });
});

//認証機能
Auth::routes();
