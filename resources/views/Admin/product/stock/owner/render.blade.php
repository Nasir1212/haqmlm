@foreach ($stocks as $key => $stock)
<tr>
    <td>{{ $key+1 }}</td>
    <td>{{ $stock?->owner?->name }}</td>
    <td>{{ $stock?->product?->name }}</td>
    <td>{{ $stock?->product?->category?->name }}</td>
    <td @if ($gsd->id == 1) id="stockId_{{ $stock?->id  }}" onblur="save_change(this,{{ $stock?->id  }})" ondblclick="this.setAttribute('contenteditable', 'true'); this.focus();" @endif>{{ $stock?->qty }}</td>
 
</tr> 
@endforeach