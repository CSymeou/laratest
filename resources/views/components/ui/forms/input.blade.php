@props([
  'editing' => [],
  'max' => null,
  'min' => null, 
  'name' => 'name',
  'type' => 'text',
  'value' => null, //Edited record in EDIT forms.
])

<div class="form-group">
  <label for="name">{{$slot}}</label>
  <input 
    type="{{$type}}" 
    class="form-control" 
    name="{{$name}}"
    @if($value !== null)
      value="{{$value}}"
    @elseif(isset($editing[$name])))
      value="{{old($name, $editing[$name])}}"
    @else
      value="{{old($name)}}"
    @endif
    @if($min !== null)
      min="{{$min}}"
    @endif
    @if($max !== null)
      max="{{$max}}"
    @endif
    />
</div>
@error($name)
  <div class="alert alert-danger">{{ $message }}</div>
@enderror