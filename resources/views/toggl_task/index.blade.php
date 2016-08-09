@extends('layouts.toggl')

@section('import_button_action', action('TogglTaskController@import'))
@section('import_button_label', 'Tasks')

@section('table')
	@if (count($tasks) > 0)
		<div class="panel panel-default">
			<div class="panel-heading">
				Tasks
			</div>

			<div class="panel-body">
				<table class="table table-striped table-hover task-table">
					<colgroup>
						<col width="150"/>
						<col/>
						<col width="80"/>
						<col width="80"/>
						<col width="80"/>
					</colgroup>
					<thead>
						<th>Project</th>
						<th>Name</th>
						<th class="text-center">Active</th>
						<th class="text-center">Estimated</th>
						<th class="text-center">Tracked</th>
					</thead>

					<tbody>
						@foreach ($tasks as $_task)
							<tr class="{{ $_task->exceeded }}">
								<td>{{ $_task->project->name }}</td>
								<td>{{ $_task->name }}</td>
								<td class="text-center">{{ $_task->active ? 'Yes' : 'No' }}</td>
								<td class="text-center">{{ $_task->estimated or '-' }}</td>
								<td class="text-center">{{ $_task->tracked or '-' }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	@else
		<p>No Tasks found. Click "Import" above to import them from Toggl.</p>
	@endif
@endsection
