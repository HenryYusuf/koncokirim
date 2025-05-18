<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class BannerController extends Controller
{
    public function adminAllBanner()
    {
        $banners = Banner::latest()->get();

        return view('admin.backend.banner.all_banner', compact('banners'));
    }

    public function adminAddBannerStore(Request $request)
    {
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(400, 400)->save(public_path('upload/banner/' . $nameGen));
            $saveUrl = 'upload/banner/' . $nameGen;

            Banner::create([
                'url' => $request->url,
                'image' => $saveUrl
            ]);
        }

        $notification = array(
            'message' => 'Banner Inserted Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.all.banner')->with($notification);
    }

    public function adminEditBanner(Banner $banner)
    {
        if ($banner) {
            $banner->image = asset($banner->image);
        }

        return response()->json($banner);
    }

    public function adminEditBannerUpdate(Request $request)
    {
        $bannerId = $request->id;

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(400, 400)->save(public_path('upload/banner/' . $nameGen));
            $saveUrl = 'upload/banner/' . $nameGen;

            Banner::find($bannerId)->update([
                'url' => $request->url,
                'image' => $saveUrl
            ]);

            $notification = array(
                'message' => 'Banner Updated Successful',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.all.banner')->with($notification);
        } else {
            Banner::find($bannerId)->update([
                'url' => $request->url,
            ]);

            $notification = array(
                'message' => 'Banner Updated Successful',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.all.banner')->with($notification);
        }
    }

    public function adminDeleteBanner(Banner $banner)
    {
        $fullPath = public_path($banner->image);
        if(file_exists($fullPath))
        {
            unlink($fullPath);
        }

        $banner->delete();

        $notification = array(
            'message' => 'Banner Deleted Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.all.banner')->with($notification);
    }
}
