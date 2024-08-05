<?php

namespace App\Http\Controllers;

use App\Http\Resources\SkuCategoryResource;
use App\Models\SkuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkuCategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request['perPage'];
            $data = SkuCategory::orderBy('id')->paginate($perPage);
            $pages_count = ceil($data->total()/$perPage);
            $labels = [];
            for ($i=1; $i <= $pages_count; $i++){
                (array_push($labels,$i));
            }
            return response([
                "data"=>SkuCategoryResource::collection($data),
                "pages"=>$pages_count,
                "total"=> $data->total(),
                "labels"=> $labels,
            ], 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }
    public function indexSite()
    {
        try {
            $data = SkuCategory::orderBy('id')->where('active',1)->get();
            return response(SkuCategoryResource::collection($data), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function show(SkuCategory $skuCategory)
    {
        try {
            return response(new SkuCategoryResource($skuCategory), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all('title'),
            [
                'title' => 'required|unique:sku_categories',
            ],
            [
                'title.required' => 'لطفا عنوان را وارد کنید',
                'title.unique' => 'این عنوان قبلا ثبت شده است',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        try {
            $data = SkuCategory::create($request->except('image'));
            if ($request['image']) {
                $name = 'sku_category_' . $data['id'] . '_' . uniqid() . '.png';
                $image_path = (new ImageController)->uploadImage($request['image'], $name, 'images/skus/');

                $data->update(['image' => '/' . $image_path]);
                (new ImageController)->resizeImage('images/skus/',$name);

            }

            return response(new SkuCategoryResource($data), 201);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function update(Request $request,SkuCategory $skuCategory)
    {
        $validator = Validator::make($request->all('title'),
            [
                'title' => 'required|unique:sku_categories,title,' . $skuCategory['id'],
            ],
            [
                'title.required' => 'لطفا عنوان را وارد کنید',
                'title.unique' => 'این عنوان قبلا ثبت شده است',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        try {
            $skuCategory->update($request->except('image'));
            if ($request['image']) {
                $name = 'sku_category_' . $skuCategory['id'] . '_' . uniqid() . '.png';
                $image_path = (new ImageController)->uploadImage($request['image'], $name, 'images/skus/');
                if ($skuCategory['image']){
                    $file_to_delete = ltrim($skuCategory['image'], $skuCategory['image'][0]); //remove '/' from file name start
                    $file_to_delete_thumb = ltrim(str_replace('.png','_thumb.png',$file_to_delete));
                    if (file_exists($file_to_delete)){  unlink($file_to_delete);}
                    if (file_exists($file_to_delete_thumb)){  unlink($file_to_delete_thumb);}
                }

                $skuCategory->update(['image' => '/' . $image_path]);

                (new ImageController)->resizeImage('images/skus/',$name);



            }

            return response(new SkuCategoryResource($skuCategory), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = SkuCategory::where('id',$request['id'])->first();
            $data->Skus->each->delete();

            if ($data['image']){
                $file_to_delete = ltrim($data['image'], $data['image'][0]);
                $file_to_delete_thumb = str_replace('.png','_thumb.png',$file_to_delete);
                if (file_exists($file_to_delete)){ unlink($file_to_delete); }
                if (file_exists($file_to_delete_thumb)){ unlink($file_to_delete_thumb); }
            }
            $data->delete();
            return response("category and it's subsets deleted", 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function activeToggle(SkuCategory $skuCategory)
    {
        try {
            $skuCategory->update(['active' => !$skuCategory['active']]);
            return response(new SkuCategoryResource($skuCategory), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

}
