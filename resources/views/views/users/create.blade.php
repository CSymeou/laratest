@extends('layouts.app')

@section('content')

<x-ui.layout.block>
  <x-ui.cards.card header="New user">
    <x-ui.forms.form 
      method="POST" 
      action="{{route('users.store')}}" 
      submitText="Create"
      cancelPath="{{route('home.index')}}"
      >
      <x-users.form></x-users.form>
    </x-ui.forms.form>
  </x-ui.cards.card>
</x-ui.layout.block>

@endsection