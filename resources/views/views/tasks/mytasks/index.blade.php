@extends('layouts.app')

@section('content')

<x-ui.layout.block>
  <x-ui.cards.card header="My Tasks">
    <x-tasks.mytasks.table :tasks=$tasks></x-tasks.mytasks.table>
    <x-ui.buttons.nav-button href="{{route('tasksToUsers.create', ['user' => auth()->id()])}}">
      Assign new task
    </x-ui.buttons.nav-button>
  </x-ui.cards.card>
</x-ui.layout.block>

@endsection