@extends('layouts.app') 

@section('title', 'List of tasks')

@section('content')
	@forelse($tasks as $task)
		<a href="{{ route('tasks.show', ['task' => $task->id]) }}"><h3>{{ $task->title }}</h3></a>
	@empty
		<p>There are no tasks</p>
	@endforelse
@endsection