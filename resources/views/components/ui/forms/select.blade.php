@props([
  'allowNull' => true,
  'editing' => [],
  'name' => '',
  'options' => [],
  'optionsValue' => 'id',
  'optionsName' => 'name'
])
<div class="form-group">
  <label for="exampleFormControlSelect1">{{$slot}}</label>
  <select class="form-control" name="{{$name}}" id="exampleFormControlSelect1">
    @if($allowNull)
      <option></option>
    @endif
    @foreach($options as $option)
      <option 
        @if((old($name) == $option[$optionsValue]) || 
            (isset($editing[$name]) && ($editing[$name] == $option[$optionsValue])))
        selected
        @endif
        value="{{$option[$optionsValue]}}"
      >
        {{$option[$optionsName]}}
      </option>
    @endforeach
  </select>
</div>