<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    /**
     * function store image uploaded
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {


        $this->validate($request, [
            'image' => 'required',
            'description'=>'required'
        ]);


        if ($request->image) {
            $image = $request->image;
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->image)->save(public_path('images/') . $name);
        }

        $image = new Image();
        $image->image_name = $name;
        $image->description = $request->description;
        $image->Qr = mt_rand(1,1518488);
        $image->barCode = rand(1111111111,9999999999);
        $image->save();

        return response()->json(['success' => 'You have successfully uploaded an image'], 200);
    }

    /**
     * function search in image when description = keywords
     * @param Request $request
     * @return array
     */
    public function search(Request $request)
    {
        $error = ['error' => 'No results found, please try with different keywords.'];

        if ($request->has('q')) {
            $images = Image::where('description', 'like', '%' . $request->q . '%')->get();
            return $images->count() ? $images : $error;
        }

        return $error;

    }


    /**
     * function get Recent Docs upload limit 5
     * @return mixed
     */
    public function latestDoc()
    {
        $images = Image::latest()->limit(5)->get();
        return $images;
    }

    public function getImage(Request $request)
    {
       $image = Image::find($request->id);
       return $image;
    }

}
