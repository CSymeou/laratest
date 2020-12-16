@props([
  'method' => 'POST',
  'action' => '',
  'submitText' => 'Create',
  'cancelPath' => ''
])

<form method="{{$method}}" action="{{$action}}">
  {{ csrf_field() }}

  <div>
    {{ $slot }}
  </div>

  <div>
    <x-ui.buttons.form-submit-button>{{$submitText}}</x-ui.buttons.form-submit-button>
    <x-ui.buttons.nav-button :href="$cancelPath">Cancel</x-ui.buttons.nav-button>
  </div>
</form>