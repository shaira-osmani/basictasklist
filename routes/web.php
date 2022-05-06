<?php

use Illuminate\Support\Facades\Route;
use App\Models\Task;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $tasks = Task::orderby('created_at' , 'asc')->get();
    return view('tasks', [
        'tasks' => $tasks
    ]);

});

Route::post('/task', function( Request $request){
    $validator = Validator::make($request->all(),[
        'name' => 'required | max:255',
    ]);

    if ($validator->fails()) {
        return redirect('/')
        ->withInput()
        ->withErrors($validator);
    }

    $tasks = new Task;
    $tasks->name = $request->name;
    $tasks->save();

    return redirect('/');

});

Route::delete('/task/{id}', function($id){

    Task::findOrFail($id)->delete();

    return redirect('/');

});
