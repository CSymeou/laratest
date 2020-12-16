@extends('layouts.app')

@section('content')

<x-ui.layout.block>
  <x-ui.cards.card header="Assign task to user">
    @if(count($tasks) > 0)
      <x-ui.forms.form 
        method="POST" 
        action="{{ route('tasksToUsers.store', ['user' => $user->id]) }}" 
        submitText="Assign"
        cancelPath="{{route('home.index')}}"
        >
        <x-ui.forms.select 
          :allowNull="false"
          name="task_id"
          :options="$tasks" 
          optionsValue="id" 
          optionsName="name">
          Select task
        </x-ui.forms.select>
      </x-ui.forms.form>
    @else
      <div class="mb-2"><strong>There are no currently unassigned tasks.</strong></div>
      <x-ui.buttons.nav-button href="{{route('home.index')}}">Back</x-ui.buttons.nav-button>
    @endif
  </x-ui.cards.card>
</x-ui.layout.block>

@endsection