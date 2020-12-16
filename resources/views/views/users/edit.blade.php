@extends('layouts.app')

@section('content')

<x-ui.layout.block>
  <x-ui.cards.card header="Edit task">
    <x-ui.forms.form 
      method="POST" 
      action="{{route('users.update', ['user' => $user->id]) }}" 
      submitText="Update"
      cancelPath="{{route('home.index')}}"
      >
      @method('PATCH')
      <x-users.form :editing="$user"></x-users.form>
    </x-ui.forms.form>
  </x-ui.cards.card>
</x-ui.layout.block>

@endsection