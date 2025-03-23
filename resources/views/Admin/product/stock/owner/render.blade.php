@foreach ($stocks as $key => $stock)
<tr>
    <td>{{ $key+1 }}</td>
    <td>{{ $stock->owner->name }}</td>
    <td>{{ $stock->product->name }}</td>
    <td>{{ $stock->product->category->name }}</td>
    <td>{{ $stock->qty }}</td>
 
</tr> 
@endforeach