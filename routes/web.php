<?php

use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Route;

// INDEX
Route::get('tasks', function () {
    return view('index', ['tasks' => Task::latest()->paginate(5)]); // Gets the latest record based on the created_at column and paginates them
})->name('tasks.index');

// CREATE
Route::view('tasks/create', 'create')->name('tasks.create');
Route::post('tasks/create', function (TaskRequest $request) {
    $task = Task::create($request->validated());
    return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Task created successfully!');
})->name('tasks.store');

// EDIT
Route::get('tasks/edit/{task}', function ($task) {
    return view('edit', ['task' => Task::findOrFail($task)]);
})->name('tasks.edit');
Route::put('tasks/edit/{task}', function (Task $task, TaskRequest $request) {
    $task->update($request->validated());
    return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Task edited successfully!');
})->name('tasks.update');

// SHOW
Route::get('tasks/{task}', function (Task $task) {
    return view('show', ['task' => Task::findOrFail($task->id)]); // findOrFail: if no record is find call the following: abort(Response::HTTP_NOT_FOUND); (404)
})->name('tasks.show');

// DELETE
Route::delete('tasks/delete/{task}', function (Task $task) {
    $task->delete();
    return redirect()->route('tasks.index')->with('Task deleted successfully');
})->name('tasks.destroy');

// COMPLETE
Route::put('tasks/toggle-complete/{task}', function (Task $task) {
    $task->toggleComplete();
    return redirect()->back()->with('Task updated successfully');
})->name('tasks.toggle-complete');

// FALLBACK
Route::fallback(function () { // Fallback route for any request that is not a valid route
    return redirect()->route('tasks.index');
});
