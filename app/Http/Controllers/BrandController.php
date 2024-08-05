<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Models\BrandSkuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phpseclib3\Math\Common\FiniteField\Integer;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request['perPage'];
            $data = Brand::orderByDesc('id')
                ->where('title', 'Like', '%' . $request['search'] . '%')->paginate($perPage);
            $pages_count = ceil($data->total() / $perPage);
            $labels = [];
            for ($i = 1; $i <= $pages_count; $i++) {
                (array_push($labels, $i));
            }
            return response([
                "data" => BrandResource::collection($data),
                "pages" => $pages_count,
                "total" => $data->total(),
                "labels" => $labels,
                "title" => 'برند ها',
                "tooltip_new" => 'ثبت برند جدید',
            ], 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function indexSite(Request $request)
    {
        try {
            $data = Brand::orderByDesc('id')->where('active', 1);
            if ($request['search'] != '') {
                $data = $data->where('title', 'Like', '%' . $request['search'] . '%');
            }
            if ($request['limit'] != '') {
                $data = $data->skip(0)->take($request['limit']);
            }
            $data = $data->get();

            return response(BrandResource::collection($data), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function show(Brand $brand)
    {
        try {
            return response(new BrandResource($brand), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all('title'),
            [
                'title' => 'required|unique:brands,title',
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
            $brand = Brand::create($request->all('title'));
            foreach($request['categories'] as $item){
                BrandSkuCategory::create([
                    "brand_id"=> $brand['id'],
                    "sku_category_id"=> $item['id'],
                ]);
            }
            return response(new BrandResource($brand), 201);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function update(Request $request, Brand $brand)
    {
        $validator = Validator::make($request->all('title'),
            [
                'title' => 'required|unique:brands,title,' . $brand['id'],
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
            $brand->update($request->all());
            $brand->skuCategories->each->delete();

            foreach($request['categories'] as $item){
                    BrandSkuCategory::create([
                        "brand_id"=> $brand['id'],
                        "sku_category_id"=> (Integer)$item,
                    ]);
            }
            return response(new BrandResource($brand), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function destroy(Brand $brand)
    {
        try {
            $brand->delete();
//TODO delete subsets.
            return response('Brand deleted', 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function activeToggle(Brand $brand)
    {
        try {
            $brand->update(['active' => !$brand['active']]);
            return response(new BrandResource($brand), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }


}
