<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
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
    public function brand_delete(String $id){
        $brand = Brand::findOrFail($id);
        $old_image = $brand->image;
        if($old_image){
            unlink(public_path('uploads/brands/'.$old_image));
        }
        $brand->delete();
        toastr()->closeButton()->timeOut(5000)->addSuccess('Brand deleted successfully.');
        return redirect()->route('admin.brands');
    }
    public function categories(){
        $categories = Category::orderBy('id','desc')->paginate(10);
        return view('admin.categories', compact('categories'));
    }
    public function category_add(){

        return view('admin.category_add');
    }

    public function category_store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug);
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extension;
        $this->GenerateCategoryThumbilsImage($image,$file_name);
        $category->image = $file_name;
        $category->save();
        toastr()->closeButton()->timeOut(5000)->addSuccess('Category added successfully.');
        return redirect()->route('admin.categories');
    }
    public function GenerateCategoryThumbilsImage($image,$imageName){

        $destinationPath = public_path('uploads/categories');
        $img = Image::read($image->path());
        $img->cover(124,124,"top");
        $img->resize(124,124)
        ->save($destinationPath.'/'.$imageName);
    }
    public function category_edit(String $id){
        $category = Category::findOrFail($id);
        return view('admin.category_edit', compact('category'));
    }
    public function category_update(Request $request,String $id){
       $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,'.$id,
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug);
        if($request->hasFile('image')){
            // delete old image
            $old_image = $category->image;
            if($old_image){
                unlink(public_path('uploads/categories/'.$old_image));
            }
            // upload new image
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extension;
            $this->GenerateCategoryThumbilsImage($image,$file_name);
            $category->image = $file_name;
        }
        $category->save();
        toastr()->closeButton()->timeOut(5000)->addSuccess('Category updated successfully.');
        return redirect()->route('admin.categories');


    }
    public function category_delete(Request $request,String $id){
        $category = Category::findOrFail($id);
        $old_image = $category->image;
        if($old_image){
            unlink(public_path('uploads/categories/'.$old_image));
        }
        $category->delete();
        toastr()->closeButton()->timeOut(5000)->addSuccess('Category deleted successfully.');
        return redirect()->route('admin.categories');
    }

    public function products(){
        $products = Product::orderBy('created_at','desc')->paginate(10);
        return view('admin.products', compact('products'));
    }

    


}
