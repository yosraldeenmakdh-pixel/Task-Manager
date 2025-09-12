<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function(){

    Route::get('/user', [UserController::class ,'userInfo']) ;
    Route::apiResource('tasks',TaskController::class) ;
    Route::apiResource('profiles',ProfileController::class) ;

    Route::get('all/tasks' ,[TaskController::class ,'getAllTasks'])
    ->middleware('CheckStatus') ;

    Route::post('task/{id}/favorite',[TaskController::class ,'addToFavorite']) ;
    Route::delete('task/{id}/favorite',[TaskController::class ,'removeFromFavorite']) ;
    Route::get('alltasks/favorite',[TaskController::class ,'getFavorite']) ;


}) ;

Route::prefix('tasks')->group(function(){
    Route::post('/{id}/categories',[TaskController::class,'addCategoriesToTask']) ;
    Route::get('/{id}/categories',[TaskController::class,'getTaskCategories']) ;
}) ;

Route::get('user/{id}/tasks',[UserController::class,'getTasks']) ;
Route::get('task/{id}/user',[UserController::class,'getuser']) ;

Route::prefix('categories')->group(function(){
    Route::post('/{id}/tasks',[TaskController::class,'addTasksToCategory']) ;
    Route::get('/{id}/tasks',[TaskController::class,'getCategoryTasks']) ;
}) ;

Route::post('register/',[UserController::class,'register']) ;
Route::get('login/',[UserController::class,'login']) ;
Route::post('logout/',[UserController::class,'logout'])->middleware('auth:sanctum') ;



