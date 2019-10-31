<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    /**
     * function store image uploaded with QR and Barcode
     * @param ImageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ImageRequest $request)
    {
        if ($request->image) {
            $image = $request->image;
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->image)->save(public_path('images/') . $name);
        }

        $new_item = Image::create([
            'image_name' => $name,
            'description' => $request->description,
            'Qr' => $name,
            'barCode' => rand(1111111111, 9999999999),
        ]);

        if($new_item){
            return response()->json(['success' => 'You have successfully uploaded an image'], 200);
        }
        return response()->json(['error' => 'You have Error uploaded an image']);

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

    /**
     * function get data image when send id param
     * @param Request $request
     * @return mixed
     */
    public function getImage(Request $request)
    {
        $image = Image::find($request->id);
        return $image;
    }

}
