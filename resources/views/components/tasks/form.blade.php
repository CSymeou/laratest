@props([
  'users' => [], //Users to be available in list of assignees in form
  'editing' => [] //Instance of task record being edited in EDIT form
])

<x-ui.forms.input
  :editing="$editing"
  type="text"
  name="name">
  Task name
</x-ui.forms.input>
<x-ui.forms.select 
  allowNull="true"
  :editing="$editing"
  name="assignee_id"
  :options="$users" 
  optionsValue="id" 
  optionsName="name">
  Task assignee
</x-ui.forms.select>