<?php

class HomeController extends BaseController {

	protected $layout = 'layout.master';
	
	public function getIndex()
	{
		$tasks = Task::all();
		$checked = Task::where('status', 0)->count();

		return $this->layout->content = View::make('index')
			->with('tasks', $tasks)
			->with('checked', $checked);
	}

	public function newTask()
	{
		$validator = Validator::make(
			array('task' =>  Input::get('task')),
			array('task' => 'required')
		);

		if ($validator->fails()) {
			return Response::json(array(
				'msg' => $validator->messages()->first(), 
				'msg_class' => 'danger'
			), 200);
		}

		$task = new Task;

		$task->task = Input::get('task');
		$task->status = 0;

		if ($task->save()) {
			return Response::json(array(
				'id' => $task->id,
				'task' => Input::get('task'),
				'msg' => 'New task added!', 
				'msg_class' => 'success'
			), 200);
		}

		return Response::json(array(
			'msg' => 'An error has ocurred', 
			'msg_class' => 'danger'
		), 400);
	}

	public function setStatusTask()
	{
		$task = Task::find(Input::get('id'));
		$status = Input::get('status');

		$update = Task::where('id',Input::get('id'))->update(array('status' => $status));

		if ($update) {
			$checked = Task::where('status', 0)->count();
			$all = Task::all()->count();

			return Response::json(array(
				'checked' => $checked,
				'all' => $all,
				'msg' => $status == 1 ? 'Task done!' : 'Task restored!' , 
				'msg_class' => 'success'
			), 200);
		}

		return Response::json(array(
			'msg' => 'An error has ocurred', 
			'msg_class' => 'danger'
		), 400);
	}
}
