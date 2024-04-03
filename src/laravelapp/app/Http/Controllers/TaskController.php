<?php

namespace App\Http\Controllers;

use App\Folder;
use App\task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\Edittask;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Folder $folder)

    {
        //ログインユーザーのフォルダのみ取得
        $folders = Auth::user()->folders()->get();

        //選ばれたフォルダに紐づいたタスクのみ取得
        $tasks = $folder->tasks()->get();

        return view('tasks/index', [

            'folders' => $folders,
            'current_folder_id' => $folder->id,
            'tasks' => $tasks,
        ]);
    }

    public function showCreateForm(Folder $folder)
    {
        return view('tasks/create', [
            'folder_id' => $folder->id,
        ]);
    }

    public function create(Folder $folder, CreateTask $request)
    {
        $task = new Task();
        $task->title = $request->title; // INSERT INTO tasks SET title = $request->title;
        $task->due_date = $request->due_date; //INSERT INTO tasks SET due_date = $request->due_date;

        $folder->tasks()->save($task); //リレーションを活用した保存

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }


    public function showEditForm(Folder $folder, Task $task)
    {
        $this->checkRelation($folder, $task);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    /**
     * タスク編集
     * @param Folder $folder
     * @param Task $task
     * @param EditTask $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function edit(Folder $folder, Task $task, EditTask $request)
    {
        $this->checkRelation($folder, $task);


        //2: 編集対象のタスクデータに入力値を入れてSAVEする
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        //3　最後に編集対象のタスクが属するタスク一覧画面にリダイレクト
        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }

    public function checkRelation(Folder $folder, Task $task)
    {
        if ($folder->id !== $task->folder_id) {
            about(404);
        }
    }
}
