<?php

namespace App\Http\Controllers;


use App\Http\Resources\SectorResource;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectorController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request['perPage'];
            $data = Sector::orderByDesc('id')->where('title', 'Like', '%' . $request['search'] . '%')->paginate($perPage);
            $pages_count = ceil($data->total() / $perPage);
            $labels = [];
            for ($i = 1; $i <= $pages_count; $i++) {
                (array_push($labels, $i));
            }
            return response([
                "data" => SectorResource::collection($data),
                "pages" => $pages_count,
                "total" => $data->total(),
                "labels" => $labels,
                "title" => 'محله ها',
                "tooltip_new" => 'ثبت محله جدید',
            ], 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function indexSite(Request $request)
    {
        try {
            $data = Sector::orderBy('title')->where('active', 1)->where('city_id',$request['city_id'])->get();

            return response(SectorResource::collection($data), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function show(Sector $sector)
    {
        try {
            return response(new SectorResource($sector), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all('title'),
            [
                'title' => 'required|unique:sectors,title',
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
            $sector = Sector::create($request->all());
            return response(new SectorResource($sector), 201);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function update(Request $request, Sector $sector)
    {
//        $validator = Validator::make($request->all('title'),
//            [
//                'title' => 'required|unique:sectors,title,' . $sector['id'],
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
            $sector->update($request->all());
            return response(new SectorResource($sector), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function destroy(Sector $sector)
    {
        try {
            $sector->delete();
//TODO delete subsets.
            return response('Sector deleted', 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function activeToggle(Sector $sector)
    {
        try {
            $sector->update(['active' => !$sector['active']]);
            return response(new SectorResource($sector), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }
    public function byRegion($id)
    {
        try {
            $dataa = Sector::where('region_id',$id)->get();
            return response(SectorResource::collection($dataa), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

}
