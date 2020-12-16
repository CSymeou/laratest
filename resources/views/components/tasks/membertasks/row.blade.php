@props([
  'task' => [],
  'team' => []
])

<tr>
  <td>
    {{$task->name}}
  </td>
  <td>
    {{$task->progress}}%
  </td>
  @can('manage-team', $team)
    <td>
      <x-ui.tables.table-delete-btn 
        href="{{route('tasksToUsers.destroy', ['task' => $task->id])}}"
        :id="$task->id"
        type="task">
        Are you sure you want to unassign this task from the user?
      </x-ui.tables.table-delete-btn>
    </td>
  @endcan
</tr>
