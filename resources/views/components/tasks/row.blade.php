@props([
  'task' => []
])

<tr>
  <th scope="row">{{$task->id}}</th>
  <td>{{$task->name}}</td>
  <td>
    @if ($task->progress == 100) 
      <span class="badge bg-cyan">Completed</span>
    @else 
      <span class="badge bg-purple">Work in Progress</span>
    @endif
  </td>
  <td>
    @if ($task->assignee_id == null)
      <span class="badge bg-pink">Unassigned</span>
    @else 
      <span class="badge bg-orange">Assigned</span>
    @endif
  </td>
  <td>
    <x-ui.tables.table-edit-btn href="{{route('tasks.edit', ['task' => $task->id])}}"></x-ui.tables.table-edit-btn>
  </td>
  <td>
    <x-ui.tables.table-delete-btn 
      href="{{route('tasks.destroy', ['task' => $task->id])}}"
      :id="$task->id"
      type="task"
      >
      Are you sure you want to remove this task?
    </x-ui.tables.table-delete-btn>
  </td>
</tr>
