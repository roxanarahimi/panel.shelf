<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProvinceResource;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProvinceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request['perPage'];
            $data = Province::orderByDesc('id')
                ->where('title', 'Like', '%' . $request['search'] . '%')->paginate($perPage);
            $pages_count = ceil($data->total() / $perPage);
            $labels = [];
            for ($i = 1; $i <= $pages_count; $i++) {
                (array_push($labels, $i));
            }
            return response([
                "data" => ProvinceResource::collection($data),
                "pages" => $pages_count,
                "total" => $data->total(),
                "labels" => $labels,
                "title" => 'استان ها',
                "tooltip_new" => 'ثبت استان جدید',
            ], 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function indexSite(Request $request)
    {
        try {
            $data = Province::orderByDesc('id')->where('active', 1);
            if ($request['search'] != '') {
                $data = $data->where('title', 'Like', '%' . $request['search'] . '%');
            }
            if ($request['limit'] != '') {
                $data = $data->skip(0)->take($request['limit']);
            }
            $data = $data->get();

            return response(ProvinceResource::collection($data), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function show(Province $province)
    {
        try {
            return response(new ProvinceResource($province), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all('title'),
            [
                'title' => 'required|unique:provinces,title',
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
            $province = Province::create($request->all('title'));
            return response(new ProvinceResource($province), 201);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function update(Request $request, Province $province)
    {
        $validator = Validator::make($request->all('title'),
            [
                'title' => 'required|unique:provinces,title,' . $province['id'],
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
            $province->update($request->all());
            return response(new ProvinceResource($province), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function destroy(Province $province)
    {
        try {
            $province->delete();
//TODO delete subsets.
            return response('Province deleted', 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function activeToggle(Province $province)
    {
        try {
            $province->update(['active' => !$province['active']]);
            return response(new ProvinceResource($province), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }


}
