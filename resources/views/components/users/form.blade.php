@props([
  'editing' => [] //Instance of user record being edited in EDIT form
])

<x-ui.forms.input
  :editing="$editing"
  type="text"
  name="name">
  User name
</x-ui.forms.input>
<x-ui.forms.input
  :editing="$editing"
  type="email"
  name="email">
  User email
</x-ui.forms.input>
<x-ui.forms.input
  :editing="$editing"
  type="password"
  name="password"
  value="">
  Password
</x-ui.forms.input>
<x-ui.forms.input
  :editing="$editing"
  type="password"
  name="password_confirmation"
  value="">
  Confirm password
</x-ui.forms.input>