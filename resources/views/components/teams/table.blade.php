@props([
  'teams' => []
])

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Team leader</th>
      <th scope="col">View</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($teams as $team)
      <x-teams.row :team="$team"></x-teams.row>
    @endforeach
  </tbody>
</table>