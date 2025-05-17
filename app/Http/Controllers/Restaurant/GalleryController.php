<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class GalleryController extends Controller
{
    public function restaurantAllGallery()
    {
        $galleries = Gallery::latest()->get();

        return view('restaurant.backend.gallery.all_gallery', compact('galleries'));
    }

    public function restaurantAddGallery()
    {
        return view('restaurant.backend.gallery.add_gallery');
    }

    public function restaurantAddGalleryStore(Request $request)
    {
        $images = $request->file('gallery_image');

        foreach ($images as $key => $image) {

            $manager = new ImageManager(new Driver());
            $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(500, 500)->save(public_path('upload/gallery/' . $nameGen));
            $saveUrl = 'upload/gallery/' . $nameGen;

            Gallery::insert([
                'restaurant_id' => Auth::guard('restaurant')->id(),
                'gallery_image' => $saveUrl
            ]);
        }

        $notification = array(
            'message' => 'Gallery Image Inserted Successful',
            'alert-type' => 'success'
        );
        return redirect()->route('restaurant.all.gallery')->with($notification);
    }

    public function restaurantEditGallery(Gallery $gallery)
    {
        return view('restaurant.backend.gallery.edit_gallery', compact('gallery'));
    }

    public function restaurantEditGalleryUpdate(Request $request)
    {
        $galleryId = $request->id;

        if ($request->file('gallery_image')) {
            $image = $request->file('gallery_image');
            $manager = new ImageManager(new Driver());
            $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(500, 500)->save(public_path('upload/gallery/' . $nameGen));
            $saveUrl = 'upload/gallery/' . $nameGen;

            $gallery = Gallery::find($galleryId);

            if ($gallery->gallery_image) {
                $fullPath = public_path($gallery->gallery_image);
                unlink($fullPath);
            }

            $gallery->update([
                'gallery_image' => $saveUrl
            ]);

            $notification = array(
                'message' => 'Gallery Updated Successful',
                'alert-type' => 'success'
            );

            return redirect()->route('restaurant.all.gallery')->with($notification);
        } else {
            $notification = array(
                'message' => 'No Image Selected for Update',
                'alert-type' => 'warning'
            );

            return redirect()->back()->with($notification);
        }
    }

    public function restaurantDeleteGallery(Gallery $gallery)
    {
        $fullPath = public_path($gallery->gallery_image);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        $gallery->delete();

        $notification = array(
            'message' => 'Gallery Deleted Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('restaurant.all.gallery')->with($notification);
    }
}
