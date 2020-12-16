@props([
  'users' => []
])

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Password</th>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>
    </tr>
    <tbody>
      @foreach ($users as $user)
        <x-users.row :user="$user"></x-users.row>
      @endforeach
    </tbody>
  </thead>
</table>