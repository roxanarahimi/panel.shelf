<?php

namespace App\Http\Controllers;

use App\Http\Resources\SkuResource;
use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class SkuController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request['perPage'];
            $data = Sku::orderByDesc('id')
                ->where('title', 'Like', '%' . $request['search'] . '%')->paginate($perPage);
            $pages_count = ceil($data->total() / $perPage);
            $labels = [];
            for ($i = 1; $i <= $pages_count; $i++) {
                (array_push($labels, $i));
            }
            return response([
                "data" => SkuResource::collection($data),
                "pages" => $pages_count,
                "total" => $data->total(),
                "labels" => $labels,
                "title" => 'sku ها',
                "tooltip_new" => 'ثبت sku جدید',
            ], 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function latest()
    {
        try {
            $data = Sku::all()->sortByDesc('id')->take(4);
            return response(SkuResource::collection($data), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function indexSite(Request $request)
    {
        try {
            $data = Sku::orderBy('id')//->whereHas('activeCategory')
                ->where('sku_category_id', $request['sku_category_id'])
                ->where('brand_id', $request['brand_id'])
                ->where('active', 1)->get();

            return response(SkuResource::collection($data), 200);
//            return response(new SkuResource($data), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }
    public function show(Sku $sku)
    {
        try {
            return response( new SkuResource($sku), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }


    public function saveImages($requestImages, $skuId)
    {
        try {
            $images = '';
            for ($i = 0; $i < count($requestImages); $i++) {
                if ($requestImages[$i][1]) {
                    $name = 'sku_' . $skuId . '_' . uniqid() . '.png';
                    $image_path = (new ImageController)->uploadImage($requestImages[$i][1], $name, 'images/');
//                    (new ImageController)->resizeImage('images/', $name);
                    $images = $images . '/' . $image_path . ',';
                } else if ($requestImages[$i][0]) {
                    $images = $images . $requestImages[$i][0] . ',';
                }
            }
            return $images;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function store(Request $request)
    {
//        $validator = Validator::make($request->all('title'),
//            [
//                'title' => 'required|unique:skus,title',
//            ],
//            [
//                'title.required' => 'لطفا عنوان را وارد کنید',
//                'title.unique' => 'این عنوان قبلا ثبت شده است',
//            ]
//        );
//        if ($validator->fails()) {
//            return response()->json($validator->messages(), 422);
//        }
        try {
            $sku = Sku::create($request->except('image', 'related_skus'));
            if ($request['image']) {
                $name = 'sku_' . $sku['id'] . '_' . uniqid() . '.png';
                $image_path = (new ImageController)->uploadImage($request['image'], $name, 'images/skus/');
                $sku->update(['image' => '/' . $image_path]);

                (new ImageController)->resizeImage('images/skus/', $name);
            }
            return response(new SkuResource($sku), 201);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function update(Request $request, Sku $sku)
    {
//        $validator = Validator::make($request->all('title'),
//            [
//                'title' => 'required|unique:skus,title,' . $sku['id'],
//            ],
//            [
//                'title.required' => 'لطفا عنوان را وارد کنید',
//                'title.unique' => 'این عنوان قبلا ثبت شده است',
//            ]
//        );

//        if ($validator->fails()) {
//            return response()->json($validator->messages(), 422);
//        }
        try {
            $sku->update($request->all());
            return response(new SkuResource($sku), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function sort(Request $request, Sku $sku)
    {
//        $validator = Validator::make($request->all('title'),
//            [
//                'title' => 'required|unique:skus,title,' . $sku['id'],
//            ],
//            [
//                'title.required' => 'لطفا عنوان را وارد کنید',
//                'title.unique' => 'این عنوان قبلا ثبت شده است',
//            ]
//        );
//
//        if ($validator->fails()) {
//            return response()->json($validator->messages(), 422);
//        }
        try {
            $sku->update($request->all('index'));
            return response(new SkuResource($sku), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function destroy(Sku $sku)
    {

        try {
            if ($sku['image']) {
                $file_to_delete = ltrim($sku['image'], $sku['image'][0]); //remove '/' from file name start
                $file_to_delete_thumb = ltrim(str_replace('.png', '_thumb.png', $file_to_delete));
                if (file_exists($file_to_delete)) {
                    unlink($file_to_delete);
                }
                if (file_exists($file_to_delete_thumb)) {
                    unlink($file_to_delete_thumb);
                }
            }
            $sku->delete();
            return response('sku deleted', 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function activeToggle(Sku $sku)
    {
        try {
            $sku->update(['active' => !$sku['active']]);
            return response(new SkuResource($sku), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function updateOrder(Request $request, Sku $sku)
    {
        try {
            $sku->update(['images' => substr($request['images'], 0, -1)]);
            return response(new SkuResource($sku), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function byCatPanel($id)
    {
        try {
            $data = Sku::orderBy('title')->where('sku_category_id', $id)->where('active', 1)->get();
            return response(["data" => SkuResource::collection($data)], 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function byCat($id)
    {
        try {
            $data = Sku::orderBy('id')->where('sku_category_id', $id)->where('active', 1)->get();
            foreach ($data as $item) {
                $thumb2 = $item->image ? str_replace('.png', '_thumb.png', $item->image) : '';
                $item->thumb = $thumb2;
            }
            return response([
                "data" => $data,
            ], 200);
        } catch (\Exception $exception) {
            return response($exception);

        }
    }

    public function fix(Request $request)
    {
        $x = DB::connection()->getDatabaseName();
        return $x;
    }
}

