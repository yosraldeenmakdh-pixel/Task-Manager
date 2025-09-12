<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Category;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskController extends Controller
{
    public function store(StoreTaskRequest $request)
    {
        $user_id = Auth::user()->id ;
        $validData = $request->validated() ;
        $validData['user_id'] = $user_id ;
        $task = Task::create($validData);
        return response()->json($task, 201);
    }

    public function index(){
        $data = Auth::user()->tasks()->orderByRaw("FIELD(priority,'high','medium','low')")->get() ;
        return response()->json($data ,200) ;
    }


    public function update($id ,UpdateTaskRequest $request){
        $user_id = Auth::user()->id ;
        $task = Task::findOrFail($id) ;
        if($user_id != $task->user_id)
            return response()->json([
            'message'=>'connot update this task because you are not the owner'], 404);

        // return response()->json([$user_id ,$task_user_id]);
        $task->update($request->validated()) ;
        return response()->json($task ,200) ;
    }

    public function show($id){
        $user_id = Auth::user()->id ;
        $task = Task::findOrFail($id) ;
        if($user_id != $task->user_id)
            return response()->json([
            'message'=>'connot show details this task because you are not the owner'], 404);

        return response()->json($task ,200) ;
    }

    public function destroy($id){

        try{
            $user_id = Auth::user()->id ;
            $task = Task::findOrFail($id) ;
        }

        catch(ModelNotFoundException $e){
            return response()->json([
            'error'=>'your id task entry is not found' ,
            'message'=>$e->getMessage()
            ], 404);
        }
        catch(Exception $g){
            return response()->json([
                'error'=>'Gernal Error' ,
                'message'=>$g->getMessage()
            ], 404);
        }


        if($user_id != $task->user_id)
            return response()->json([
            'message'=>'connot delete this task because you are not the owner'], 404);



        $task->delete() ;
        return response()->json(["message"=>"The Task is Deleted"],200) ;
    }

    public function addCategoriesToTask(Request $request ,$id){
        $task = Task::findOrFail($id) ;
        $task->catrgories()->attach($request->category_id) ;
        return response()->json(['message'=>'category attached successfully'], 200);
    }
    public function getTaskCategories(Request $request,$id){
        $task = Task::findOrFail($id)->catrgories ;
        return response()->json($task, 200);
    }
    public function getCategoryTasks(Request $request,$id){
        $category = Category::findOrFail($id)->tasks ;
        return response()->json($category, 200);
    }

    public function addTasksToCategory(Request $request ,$id){
        $category = Category::findOrFail($id) ;
        $category->tasks()->attach($request->task_id) ;
        return response()->json(["message"=>"task attached seccessfully"], 200);
    }

    public function getAllTasks(){
        $tasks = Task::all() ;
        return response()->json($tasks, 200);
    }


    public function addToFavorite($id){
        $task = Task::findOrFail($id) ;
        $user = Auth::user() ;
        $user->favoriteTask()->syncWithoutDetaching($task) ;
        return response()->json(['message'=>'your task added to the favorite'], 200);
    }
    public function removeFromFavorite($id){
        $task = Task::findOrFail($id) ;
        $user = Auth::user() ;
        $user->favoriteTask()->detach($task) ;
        return response()->json(['message'=>'your task removed from the favorite'], 200);
    }
    public function getFavorite(){
        $taskFavorite = Auth::user()->favoriteTask ;

        return response()->json([
            'message'=>'your task removed from the favorite',
            'The Favorite'=>$taskFavorite
        ], 200);
    }

}
