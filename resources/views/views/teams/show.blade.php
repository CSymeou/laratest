@extends('layouts.app')

@section('content')

<x-ui.layout.block>
  <x-ui.cards.card header="Team: #{{$team->id}} - members and their tasks">
    @foreach($members as $member)
      <div class="ml-2 mb-5">
        <strong>
          {{$member->name}}
        </strong>
        @if(count($member->tasks) > 0)
          <x-tasks.membertasks.table :team="$team" :tasks="$member->tasks">
          </x-tasks.membertasks.table>
        @else 
          <p>There are no tasks assigned to this user</p>
        @endif
      </div>
    @endforeach
  </x-ui.cards.card>
</x-ui.layout.block>

@endsection