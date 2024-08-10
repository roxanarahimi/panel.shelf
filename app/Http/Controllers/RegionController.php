<?php

namespace App\Http\Controllers;

use App\Http\Resources\RegionResource;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegionController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request['perPage'];
            $data = Region::orderByDesc('id')
                ->where('title', 'Like', '%' . $request['search'] . '%')->paginate($perPage);
            $pages_count = ceil($data->total() / $perPage);
            $labels = [];
            for ($i = 1; $i <= $pages_count; $i++) {
                (array_push($labels, $i));
            }
            return response([
                "data" => RegionResource::collection($data),
                "pages" => $pages_count,
                "total" => $data->total(),
                "labels" => $labels,
                "title" => 'منطقه ها',
                "tooltip_new" => 'ثبت منطقه جدید',
            ], 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function indexSite(Request $request)
    {
        try {
            $data = Region::orderByDesc('id')->where('active', 1);
            if ($request['search'] != '') {
                $data = $data->where('title', 'Like', '%' . $request['search'] . '%');
            }
            if ($request['limit'] != '') {
                $data = $data->skip(0)->take($request['limit']);
            }
            $data = $data->get();

            return response(RegionResource::collection($data), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function show(Region $region)
    {
        try {
            return response(new RegionResource($region), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function store(Request $request)
    {
//        $validator = Validator::make($request->all('title'),
//            [
//                'title' => 'required|unique:regions,title',
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
            $region = Region::create($request->all());
            return response(new RegionResource($region), 201);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function update(Request $request, Region $region)
    {
//        $validator = Validator::make($request->all('title'),
//            [
//                'title' => 'required|unique:regions,title,' . $region['id'],
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
            $region->update($request->all());
            return response(new RegionResource($region), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function destroy(Region $region)
    {
        try {
            $region->delete();
//TODO delete subsets.
            return response('Region deleted', 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }


    public function activeToggle(Region $region)
    {
        try {
            $region->update(['active' => !$region['active']]);
            return response(new RegionResource($region), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }
    public function byCity($id)
    {
        try {
            $dataa = Region::where('city_id',$id)->get();
            return response(RegionResource::collection($dataa), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

}
