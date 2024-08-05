<?php

namespace App\Http\Controllers;


use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request['perPage'];
            $data = City::orderByDesc('id')
                ->where('title', 'Like', '%' . $request['search'] . '%')->paginate($perPage);
            $pages_count = ceil($data->total() / $perPage);
            $labels = [];
            for ($i = 1; $i <= $pages_count; $i++) {
                (array_push($labels, $i));
            }
            return response([
                "data" => CityResource::collection($data),
                "pages" => $pages_count,
                "total" => $data->total(),
                "labels" => $labels,
                "title" => 'شهر ها',
                "tooltip_new" => 'ثبت شهر جدید',
            ], 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function indexSite(Request $request)
    {
        try {
            $data = City::orderByDesc('id')->where('active', 1);
            if ($request['search'] != '') {
                $data = $data->where('title', 'Like', '%' . $request['search'] . '%');
            }
            if ($request['limit'] != '') {
                $data = $data->skip(0)->take($request['limit']);
            }
            $data = $data->get();

            return response(CityResource::collection($data), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function show(City $city)
    {
        try {
            return response(new CityResource($city), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all('title'),
            [
                'title' => 'required|unique:cities,title',
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
            $city = City::create($request->all());
            return response(new CityResource($city), 201);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function update(Request $request, City $city)
    {
        $validator = Validator::make($request->all('title'),
            [
                'title' => 'required|unique:cities,title,' . $city['id'],
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
            $city->update($request->all());
            return response(new CityResource($city), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function destroy(City $city)
    {
        try {
            $city->delete();
//TODO delete subsets.
            return response('City deleted', 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function activeToggle(City $city)
    {
        try {
            $city->update(['active' => !$city['active']]);
            return response(new CityResource($city), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }


    public function byProvince($id)
    {
        try {
            $dataa = City::where('province_id',$id)->get();
            return response(CityResource::collection($dataa), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }
}
