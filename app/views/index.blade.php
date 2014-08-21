@extends('layout.master')

@section('content')
	<section>
		<header><h1>Todos</h1></header>
		<article>
			<div>
				{{ Form::open() }}
					<p>
						<input type="text" required>
						<input type="submit" value="Add">
					</p>
				{{ Form::close() }}
			</div>
			<div>
				<ul>
					@foreach ($tasks as $task)
						<li>
							<input type="checkbox" id="{{ $task->id }}" {{ $task->status == 1 ? 'checked' : ''}} >
							<label for="{{ $task->id }}" class="{{ $task->status == 1 ? 'task-checked' : ''}}">{{ $task->task }}</label>
						</li>
					@endforeach
				</ul>
			</div>
			<footer>
				<span id="total-checked">{{ $checked }}</span> of <span id="total">{{ count($tasks) }}</span> remaining
			</footer>
		</article>
	</section>
@stop
