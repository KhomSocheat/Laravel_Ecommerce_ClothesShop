<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class AdminController extends Controller
{
     public function index(){
        return view('admin.index');
    }
    public function brands(){
        $brands = Brand::orderBy('id','desc')->paginate(10);

        return view('admin.brands', compact('brands'));
    }
    public function add_brand(){
        return view('admin.brand_add');
    }
    public function brand_store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->slug);
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extension;
        $this->GenerateBrandThumbilsImage($image,$file_name);
        $brand->image = $file_name;
        $brand->save();
        toastr()->closeButton()->timeOut(5000)->addSuccess('Brand added successfully.');
        return redirect()->route('admin.brands');
        // return redirect()->route('admin.brands')->with('success', 'Brand added successfully.');
    }

    public function GenerateBrandThumbilsImage($image,$imageName){

        $destinationPath = public_path('uploads/brands');
        $img = Image::read($image->path());
        $img->cover(124,124,"top");
        $img->resize(124,124)
        ->save($destinationPath.'/'.$imageName);
    }

    public function brand_edit($id){
        $brand = Brand::findOrFail($id);
        return view('admin.brand_edit', compact('brand'));
    }

    public function brand_update(Request $request,String $id){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,'.$id,
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->slug);
        if($request->hasFile('image')){
            // delete old image
            $old_image = $brand->image;
            if($old_image){
                unlink(public_path('uploads/brands/'.$old_image));
            }
            // upload new image
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extension;
            $this->GenerateBrandThumbilsImage($image,$file_name);
            $brand->image = $file_name;
        }
        $brand->save();
        toastr()->closeButton()->timeOut(5000)->addSuccess('Brand updated successfully.');
        return redirect()->route('admin.brands');
        // return redirect()->route('admin.brands')->with('success', 'Brand updated successfully.');
    }
}
