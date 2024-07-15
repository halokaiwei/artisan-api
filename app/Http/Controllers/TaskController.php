<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Support\Facades\Log;


class TaskController extends Controller
{
    public function viewTasks() {
        $tasks = Task::all();  //get all tasks

        $mapTasks = $tasks->map(function ($task) {  //format it to look easier
            return [
                'id' => $task->id,
                'title' => $task->title,
                'content' => $task->content,
                'tools_used' => $task->tools_used,
            ];});

        return response()->json([
            'tasks' => $mapTasks,
        ]);
    }

    public function createTask(Request $req) {
        $validator = Validator::make($req->all(), [
            'category_name' => 'required|exists:categories,name',
            'title' => 'required|string',
            'content' => 'required|string',
            'tools_used' => 'nullable|string', ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $category = Category::where('name', $req->input('category_name'))->first();  //see category_name in categories or not
        
        $task = Task::create([
            'title' => $req->input('title'),
            'content' => $req->input('content'),
            'tools_used' => $req->input('tools_used'),
            'category_id' => $category->id,
        ]);

        $this->logAction('Created task', $task->id, $req->ip());  //call logAction which save into Log(storage/laravel.log)
        return response()->json(['message' => 'Task created', 'task' => $task]);
    }

    public function updateTask(Request $req, $id) {
        $validator = Validator::make($req->all(), [
            'category_name' => 'required|exists:categories,name',
            'title' => 'required|string',
            'content' => 'required|string',
            'tools_used' => 'nullable|string', ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $category = Category::where('name', $req->input('category_name'))->first();
        $task = Task::findOrFail($id);

        $task->update([
            'title' => $req->input('title'),
            'content' => $req->input('content'),
            'tools_used' => $req->input('tools_used'),
            'category_id' => $category->id,
        ]);

        $this->logAction('Updated task', $task->id, $req->ip());
        return response()->json(['message' => 'Task updated', 'task' => $task]);
    }

    public function deleteTask(Request $req, $id){
        $task = Task::findOrFail($id);
        $task->delete();

        $this->logAction('Deleted task', $task->id, $req->ip());
        return response()->json(['message' => 'Task deleted']);
    }
    
    public function tasksByCategory(Request $req) {
        $validator = Validator::make($req->all(), [
            'category_name' => 'required|exists:categories,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $category = Category::where('name', $req->input('category_name'))->first(); //is this category name in categories?
        $tasks = Task::where('category_id', $category->id)->get();

        $mapTasks = $tasks->map(function ($task) {
            return [
                'id' => $task->id,
                'title' => $task->title,
                'content' => $task->content,
                'tools_used' => $task->tools_used,
            ]; 
        });
        return response()->json(['category_name' => $category->name,'tasks' => $mapTasks,]);
    }

    protected function logAction($action, $taskId, $ipAddress)
    {
        Log::info("Action: $action, Task ID: $taskId, IP Address: $ipAddress"); //save into Log (storage/laravel.log)
    }
    
}
