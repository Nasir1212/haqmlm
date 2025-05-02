<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


//use Image;
class MediaController extends Controller
{
    public function index(Request $request){
        $gsd = global_user_data();
        if (Auth::id() == 1) {
            if (isset($request->media_typer)) {
                $media_list = Upload::latest('id')->where('media_type', $request->media_typer)->get();
            }else{
                $media_list = Upload::latest('id')->get();
            }
        }else{
            if (isset($request->media_typer)) {
                $media_list = Upload::where('uploader_id', $gsd->id)->latest('id')->where('media_type', $request->media_typer)->get();
            }else{
                $media_list = Upload::where('uploader_id', $gsd->id)->latest('id')->get();
            } 
        }
        
        return view('Uploads.index', compact('media_list','gsd'));
   
    }



    public function store(Request $request){
        
        $gsd = global_user_data();

    if ($request->hasFile('media_file')) {
        foreach ($request->file('media_file') as $image_obj) {
            $media = new Upload();

            // Generate unique name
            $filename = Str::random(40) . '.' . $image_obj->getClientOriginalExtension();
            $media_type = $request->media_type;
            $relative_path = 'uploads/' . $media_type . '/' . $filename;
            // Save image
            $image_instance = Image::make($image_obj)->encode(); // You can also resize here
            Storage::disk('img_disk')->put($relative_path, $image_instance);
            // Save to DB
            $media->path = Storage::disk('img_disk')->url('uploads/' . $media_type . '/');
            $media->name = $filename;
            $media->media_type = $media_type;
            $media->uploader_id = $gsd->id;
            $media->save();
        }

        notify()->success('All media uploaded successfully!');
        return back();
    }

    notify()->error('No files selected!');
    return back();
    }

    public function remove(Request $request)
    {
        $media = Upload::findOrFail($request->id);
        $relative_path = 'uploads/' . $media->media_type . '/' . $media->name;
        // Delete file if exists
        if (Storage::disk('img_disk')->exists($relative_path)) {
            Storage::disk('img_disk')->delete($relative_path);
        }
        // Delete DB record
        $media->delete();
        notify()->success('Media removed successfully!');
        return back();
    }
}
