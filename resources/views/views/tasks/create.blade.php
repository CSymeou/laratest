@extends('layouts.app')

@section('content')

<x-ui.layout.block>
  <x-ui.cards.card header="New task">
    <x-ui.forms.form 
      method="POST" 
      action="{{route('tasks.store')}}" 
      submitText="Create"
      cancelPath="{{route('home.index')}}"
      >
      <x-tasks.form :users="$users"></x-tasks.form>
    </x-ui.forms.form>
  </x-ui.cards.card>
</x-ui.layout.block>

@endsection