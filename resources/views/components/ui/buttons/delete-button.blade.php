@props([
  'id',
  'type',
  'href',
  'text' => 'Delete'
])

<span class="btn btn-danger" 
    data-toggle="modal" 
    data-target="#{{$type}}{{$id}}"
    style="cursor: pointer;">
    {{ $text }}
</span>
<div 
  class="modal fade" 
  id="{{$type}}{{$id}}" 
  tabindex="-1" 
  role="dialog" 
  aria-labelledby="exampleModalLabel" 
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Wait!!!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{$slot}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-secondary" data-dismiss="modal">
          Cancel
        </button>
        <button type="button" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('deleteForm{{$type}}{{$id}}').submit();">
          Delete
        </button>
        <form 
          id="deleteForm{{$type}}{{$id}}" 
          action="{{ $href }}" 
          method="POST" 
          class="d-none">
          @csrf
          @method('DELETE')
        </form>
      </div>
    </div>
  </div>
</div>