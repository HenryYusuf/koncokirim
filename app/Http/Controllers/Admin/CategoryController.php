<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CategoryController extends Controller
{
    public function adminAllCategory()
    {
        $categories = Category::latest()->get();

        return view("admin.backend.category.all_category", compact("categories"));
    }

    public function adminAddCategory()
    {
        return view("admin.backend.category.add_category");
    }

    public function adminAddCategoryStore(Request $request)
    {
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/category/' . $nameGen));
            $saveUrl = 'upload/category/' . $nameGen;

            Category::create([
                'category_name' => $request->category_name,
                'image' => $saveUrl
            ]);
        }

        $notification = array(
            'message' => 'Category Inserted Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.all.category')->with($notification);
    }

    public function adminEditCategory(Category $category)
    {
        return view('admin.backend.category.edit_category', compact('category'));
    }

    public function adminEditCategoryUpdate(Request $request)
    {
        $categoryId = $request->id;

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/category/' . $nameGen));
            $saveUrl = 'upload/category/' . $nameGen;

            Category::find($categoryId)->update([
                'category_name' => $request->category_name,
                'image' => $saveUrl
            ]);

            $notification = array(
                'message' => 'Category Updated Successful',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.all.category')->with($notification);
        } else {
            Category::find($categoryId)->update([
                'category_name' => $request->category_name,
            ]);

            $notification = array(
                'message' => 'Category Updated Successful',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.all.category')->with($notification);
        }
    }

    public function adminDeleteCategory(Category $category)
    {
        $fullPath = public_path($category->image);
        if(file_exists($fullPath))
        {
            unlink($fullPath);
        }

        $category->delete();

        $notification = array(
            'message' => 'Category Deleted Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.all.category')->with($notification);
    }
}
