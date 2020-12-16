@props([
  'team' => [],
  'tasks' => []
])

<table class="table mb-0">
  <thead>
    <tr>
      <th>
        Task name
      </th>
      <th>
        Progress
      </th>
      @can('manage-team', $team)
        <th>
          Unassign task
        </th>
      @endcan
    </tr>
  </thead>
  <tbody>
    @foreach ($tasks as $task)
      <x-tasks.membertasks.row :task="$task" :team="$team"></x-tasks.membertasks.row>
    @endforeach
  </tbody>
</table>