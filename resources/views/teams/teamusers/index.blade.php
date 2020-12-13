@extends('layouts.app')

@section('content')

<x-ui.block>
  <x-ui.card header="My team members">
    My content here
  </x-ui.card>
</x-ui.block>

<x-ui.block align="center">
    <x-ui.nav-button 
    href="{{route('teamUsers.create')}}" 
    text="Add a user to the team">
  </x-ui.nav-button>
</x-ui.block>

@endsection