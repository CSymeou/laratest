@extends('layouts.app')

@section('content')

<x-ui.layout.block>
  <x-ui.cards.card header="My team members">
    @foreach($members as $member)
      <div class="ml-2 mb-5">
        <strong >
          {{$member->name}}
        </strong>
        @if(count($member->tasks) > 0)
          <x-tasks.membertasks.table :team="$team" :tasks="$member->tasks">
          </x-tasks.membertasks.table>
        @else 
          <p>There are no tasks assigned to this user</p>
        @endif
        <x-ui.buttons.nav-button 
          href="{{ route('tasksToUsers.create', ['user' => $member->id]) }}">
          Assign new task to this user
        </x-ui.buttons.nav-button>
        <x-ui.buttons.delete-button 
          href="{{route('teamMembers.destroy', ['team' => $team->id, 'user' => $member->id])}}" 
          text="Remove from team"
          type="user"
          id="{{$member->id}}">
          Are you sure you want to remove this user from the team?
        </x-ui.buttons.delete-button>
      </div>
    @endforeach
  </x-ui.cards.card>
</x-ui.layout.block>

<x-ui.layout.block align="center">
  <x-ui.buttons.nav-button href="{{route('teamMembers.create', ['team' => $team->id])}}">
    Add a user to the team
  </x-ui.buttons.nav-button>
</x-ui.layout.block>

@endsection