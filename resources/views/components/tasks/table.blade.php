@props([
  'tasks' => []
])

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Description</th>
      <th scope="col">Completed</th>
      <th scope="col">Assigned</th>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>
    </tr>
    <tbody>
      @foreach ($tasks as $task)
        <x-tasks.row :task="$task"></x-tasks.row>
      @endforeach
    </tbody>
  </thead>
</table>