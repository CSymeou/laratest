@extends('layouts.app')

@section('content')

<x-ui.layout.block>
  <x-ui.cards.card header="Edit progress">
    <x-ui.forms.form 
      method="POST" 
      action="{{ route('taskProgress.update', ['task' => $task->id]) }}" 
      submitText="Update"
      cancelPath="{{route('myTasks.index')}}"
      >
      @method('PATCH')
      <x-ui.forms.input
        name="progress"
        :editing="$task"
        type="number"
        max="100"
      >
        Task progress
      </x-ui.forms.input>
    </x-ui.forms.form>
  </x-ui.cards.card>
</x-ui.layout.block>

@endsection