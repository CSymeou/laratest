@extends('layouts.app')

@section('content')

<x-ui.layout.block>
  <x-ui.cards.card header="Edit task">
    <x-ui.forms.form 
      method="POST" 
      action="{{ route('tasks.update', ['task' => $task->id]) }}" 
      submitText="Update"
      cancelPath="{{route('home.index')}}"
      >
      @method('PATCH')
      <x-tasks.form :users="$users" :editing="$task"></x-tasks.form>
    </x-ui.forms.form>
  </x-ui.cards.card>
</x-ui.layout.block>

@endsection