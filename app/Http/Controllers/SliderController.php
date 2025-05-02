<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
// use Image;
use App\Models\Slider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class SliderController extends Controller
{
    public function index(){
        $gsd = global_user_data();
        $sliders =  Slider::latest('id')->paginate(10);
       
       return view('Admin.sliders.index',compact('sliders','gsd'));
   }
   
   public function create(){
       $gsd = global_user_data();
       return view('Admin.sliders.create',compact('gsd'));
   }
   
 
   
   public function store(Request $request){
    $gsd = global_user_data();

    if (Auth::id() == 1 || permission_checker($gsd->role_info, 'order_manage') == 1) {

        $slider = new Slider();
        $slider->name = $request->name;
        $slider->slug = $request->slug ? $request->slug : Str::slug($request->name);
        $slider->target_link = $request->target_link;
        $slider->slider_type = 'home';
        $slider->status = $request->status;
        $slider->created_by = $gsd->id;

        if ($request->hasFile('media_file')) {
            $image = $request->file('media_file');
            $image_name = Str::random(40) . '.' . $image->getClientOriginalExtension();

            $base_path = 'uploads/slider/';
            $full_disk_path = Storage::disk('img_disk')->path($base_path);

            // Save original
            Storage::disk('img_disk')->makeDirectory($base_path);
            Image::make($image)->save($full_disk_path . $image_name);

            // Save resized versions
            $sizes = [
                'extra_small' => 50,
                'small' => 200,
                'medium' => 400,
                'large' => 600,
            ];

            foreach ($sizes as $folder => $height) {
                $folder_path = $base_path . $folder . '/';
                Storage::disk('img_disk')->makeDirectory($folder_path);

                $resized_image = Image::make($image)->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $resized_image->save(Storage::disk('img_disk')->path($folder_path . $image_name));
            }

            $slider->image_name = $image_name;
            $slider->image_path = 'https://img.haqmultishop.com/uploads/slider/';
        }

        $slider->save();
        notify()->success('Slider Created Successfully!');
        return back();

    } else {
        notify()->error('Permission Not Allowed!');
        return back();
    }

   }
   
   public function edit(Request $request){
        $gsd = global_user_data();
        $slider =  Slider::where('id',$request->id)->first();
       

       return view('Admin.sliders.edit',compact('slider','gsd'));
   }
   
   public function update(Request $request){
    $gsd = global_user_data();

    if (Auth::id() != 1 && permission_checker($gsd->role_info, 'order_manage') != 1) {
        notify()->error('Permission Not Allowed!');
        return back();
    }

    $slider = Slider::findOrFail($request->id);

    $slider->name = $request->name;
    $slider->slug = $request->slug ? $request->slug : Str::slug($request->name);
    $slider->target_link = $request->target_link;
    $slider->status = $request->status;
    $slider->updated_by = $gsd->id;

    // If new image is uploaded
    if ($request->hasFile('media_file')) {
        $image = $request->file('media_file');
        $image_name = Str::random(40) . '.' . $image->getClientOriginalExtension();
        $media_path = 'uploads/slider/';

        // Delete old images
        if ($slider->image_name) {
            $old_paths = [
                $media_path . $slider->image_name,
                $media_path . 'extra_small/' . $slider->image_name,
                $media_path . 'small/' . $slider->image_name,
                $media_path . 'medium/' . $slider->image_name,
                $media_path . 'large/' . $slider->image_name,
            ];
            foreach ($old_paths as $old) {
                if (Storage::disk('img_disk')->exists($old)) {
                    Storage::disk('img_disk')->delete($old);
                }
            }
        }

        // Save new images in different sizes
        $sizes = [
            '' => null,
            'extra_small' => 50,
            'small' => 200,
            'medium' => 400,
            'large' => 600,
        ];

        foreach ($sizes as $folder => $height) {
            $path = $media_path . ($folder ? $folder . '/' : '');
            Storage::disk('img_disk')->makeDirectory($path);

            $img = Image::make($image);
            if ($height) {
                $img->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $img->save(Storage::disk('img_disk')->path($path . $image_name));
        }

        $slider->image_name = $image_name;
        $slider->image_path = 'https://img.haqmultishop.com/uploads/slider/';
    }

    $slider->save();

    notify()->success('Slider updated successfully!');
    return back();
   }
   
   public function remove(Request $request){
   
    $slider = Slider::findOrFail($request->id);

    // Base folder and image name
    $base_folder = 'uploads/slider/';
    $image_name = $slider->image_name;

    // Paths for all sizes including original
    $paths = [
        $base_folder . $image_name,                        // Original
        $base_folder . 'extra_small/' . $image_name,
        $base_folder . 'small/' . $image_name,
        $base_folder . 'medium/' . $image_name,
        $base_folder . 'large/' . $image_name,
    ];

    // Delete all image files
    foreach ($paths as $path) {
        if (Storage::disk('img_disk')->exists($path)) {
            Storage::disk('img_disk')->delete($path);
        }
    }

    // Delete from DB
    $slider->delete();

    notify()->success('Slider deleted successfully!');
    return back();
}
}
