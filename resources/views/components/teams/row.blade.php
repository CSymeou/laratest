@props([
  'team' => []
])

<tr>
  <th scope="row">{{$team->id}}</th>
  <td>{{$team->leader->name}}</td>
  <td>
    <x-ui.tables.table-view-btn href="{{route('teams.show', ['team' => $team->id])}}"></x-ui.tables.table-view-btn>
  </td>
</tr>
