@extends('layouts.app')

@section('content')

@can('manage-tasks')
  <x-ui.layout.block>
    <x-ui.cards.card header="All tasks">
      <x-tasks.table :tasks="$tasks">
      </x-tasks.table>
      {{$tasks->links("pagination::bootstrap-4")}}
    </x-ui.cards.card>
  </x-ui.layout.block>
  
@endcan

@can('view-users')
  <x-ui.layout.block>
    <x-ui.cards.card header="All users">
      <x-users.table :users="$users">
      </x-users.table>
    </x-ui.cards.card>
  </x-ui.layout.block>
@endcan

<x-ui.layout.block align="center">
  @can('manage-tasks')
    <x-ui.buttons.nav-button href="{{route('tasks.create')}}">
      Add a task
    </x-ui.buttons.nav-button>
  @endcan

  @can('create-users')
    <x-ui.buttons.nav-button href="{{route('users.create')}}">
      Add a new user
    </x-ui.buttons.nav-button>
  @endcan
</x-ui.layout.block>

@endsection