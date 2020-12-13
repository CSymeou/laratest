@extends('layouts.app')

@section('content')

<x-ui.block>
  <x-ui.card header="All tasks">
    My content here
  </x-ui.card>
</x-ui.block>

<x-ui.block>
  <x-ui.card header="All users">
    My content here
  </x-ui.card>
</x-ui.block>

<x-ui.block align="center">
  <x-ui.nav-button 
    href="{{route('tasks.create')}}" 
    text="Add a task">
  </x-ui.nav-button>
  <x-ui.nav-button 
    href="{{route('users.create')}}" 
    text="Add a new user">
  </x-ui.nav-button>
</x-ui.block>

@endsection