@extends('layouts.app')

@section('content')

<x-ui.layout.block>
  <x-ui.cards.card header="Teams">
    <x-teams.table :teams="$teams"></x-teams.table>
  </x-ui.cards.card>
</x-ui.layout.block>

@endsection