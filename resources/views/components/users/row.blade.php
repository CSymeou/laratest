@props([
  'user' => []
])

<tr>
  <th scope="row">{{$user->id}}</th>
  <td>{{$user->name}}</td>
  <td>{{$user->email}}</td>
  <td>************</td>
  <td>
    @can('edit-users', $user)
      <x-ui.tables.table-edit-btn href="{{route('users.edit', ['user' => $user->id])}}">
      </x-ui.tables.table-edit-btn>
    @endcan
  </td>
  <td>
    @can('edit-users', $user)
      <x-ui.tables.table-delete-btn
        href="{{route('users.destroy', ['user' => $user->id])}}"
        :id="$user->id"
        type="user"
      >
        Are you sure you want to remove this user?
      </x-ui.tables.table-delete-btn>
    @endcan
  </td>
</tr>
