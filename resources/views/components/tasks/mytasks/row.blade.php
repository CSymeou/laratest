@props([
  'task' => []
])

<tr>
  <th scope="row">{{$task->id}}</th>
  <td>{{$task->name}}</td>
  <td>{{$task->progress}}</td>
  <td>
    <x-ui.tables.table-edit-btn href="{{route('taskProgress.edit', ['task' => $task->id])}}"></x-ui.tables.table-edit-btn>
  </td>
  <td>
    <x-ui.tables.table-delete-btn 
      href="{{route('tasksToUsers.destroy', ['task' => $task->id])}}"
      :id="$task->id"
      type="task"
      >
      Are you sure you want to unassign this task from the user?
    </x-ui.tables.table-delete-btn>
  </td>
</tr>
