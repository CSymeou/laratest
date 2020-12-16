@props([
  'tasks' => []
])

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Description</th>
      <th scope="col">Progress</th>
      <th scope="col">Update progress</th>
      <th scope="col">Unassign</th>
    </tr>
    <tbody>
      @foreach ($tasks as $task)
        <x-tasks.mytasks.row :task="$task"></x-tasks.mytasks.row>
      @endforeach
    </tbody>
  </thead>
</table>