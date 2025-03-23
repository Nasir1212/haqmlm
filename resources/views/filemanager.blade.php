@extends('layouts.Back.app')
@section('content')
        <div class="w-full flex justify-items-end m-5">
            <button type="button" class="text-2xl border px-3 py-1 bg-green-600 text-white" onclick='returnFileUrl("guygbjkguygytghhbjkhu")'>Confirm</button>
            <button type="button" class="text-2xl border px-3 py-1 bg-red-700 text-white">Delete</button>
        </div>

       <div class="mx-5">
        {{ $datas->onEachSide(5)->links() }}
       </div> 
        <div class="file_list flex flex-wrap m-5 border">
            @if($datas)
            @foreach ( $datas as $key => $data)
                <div class="col-6">
                    <div class="p-2" id="img_{{ $key }}"  onclick="img_select({{$key}})" img_path="{{ asset($data->path.$data->name)}}">
                        <div class="w-100">
                            <img src="{{ asset($data->path.$data->name)}}" class="img-fluid"/>
                        </div>
                    </div>
                </div>  
            @endforeach
            @endif  
            <div class="mx-5">
                {{ $datas->onEachSide(5)->links() }}
            </div>
            
        </div>
        <div class="w-full flex justify-items-end m-5">
            <button type="button" class="text-2xl border px-3 py-1 bg-green-600 text-white" onclick='returnFileUrl()'>Confirm</button>
            <button type="button" class="text-2xl border px-3 py-1 bg-red-700 text-white">Delete</button>
        </div>
@endsection
@push('script')
<script>
    var imgpathsetter = "";
    // Simulate user action of selecting a file to be returned to CKEditor.
    function returnFileUrl() {
        var funcNum = 3;
    var fileUrl = imgpathsetter;
    window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl, function() {
        // Get the reference to a dialog window.
        var dialog = this.getDialog();
        // Check if this is the Image Properties dialog window.
        if ( dialog.getName() == 'file' ) {
            // Get the reference to a text field that stores the "alt" attribute.
            var element = dialog.getContentElement( 'info', 'txtAlt' );
            // Assign the new value.
            if ( element )
                element.setValue( 'alt text' );
        }
       
    } );
    window.close();
}

    function img_select(number){
        var img_number = 'img_'+number;
        var imgS = document.getElementById(img_number);
        var imgP = imgS.getAttribute('img_path');
        imgpathsetter = imgP;
        navigator.clipboard.writeText(imgP);
        alert("Copy Success");
    }
</script>
@endpush
        

