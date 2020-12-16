@extends('layouts.app')

@section('content')

<x-ui.layout.block>
  <x-ui.cards.card header="Assign user to team">
    @if(count($users) > 0)
      <x-ui.forms.form 
        method="POST" 
        action="{{ route('teamMembers.store', ['team' => $team->id]) }}" 
        submitText="Assign"
        cancelPath="{{route('myTeam.index')}}"
        >
        <x-ui.forms.select 
          :allowNull="false"
          name="user_id"
          :options="$users" 
          optionsValue="id" 
          optionsName="name">
          Select user
        </x-ui.forms.select>
      </x-ui.forms.form>
    @else
      <div class="mb-2"><strong>There are no users who are currently not in a team.</strong></div>
      <x-ui.buttons.nav-button href="{{route('myTeam.index')}}">Back</x-ui.buttons.nav-button>
    @endif
  </x-ui.cards.card>
</x-ui.layout.block>

@endsection