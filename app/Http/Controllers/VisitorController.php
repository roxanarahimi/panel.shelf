<?php

namespace App\Http\Controllers;

use App\Http\Resources\VisitorResource;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request['perPage'];
            $data = Visitor::orderBy('index')->orderByDesc('id')
                ->where('name', 'Like', '%' . $request['search'] . '%')->paginate($perPage);
            $pages_count = ceil($data->total() / $perPage);
            $labels = [];
            for ($i = 1; $i <= $pages_count; $i++) {
                (array_push($labels, $i));
            }
            return response([
                "data" => VisitorResource::collection($data),
                "pages" => $pages_count,
                "total" => $data->total(),
                "labels" => $labels,
                "title" => 'کارشناس ها',
                "tooltip_new" => 'ثبت کارشناس جدید',
            ], 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function indexSite(Request $request)
    {
        try {
            $data = Visitor::orderBy('index')->orderByDesc('id')->where('active', 1);
            if ($request['search'] != '') {
                $data = $data->where('name', 'Like', '%' . $request['search'] . '%');
            }
            if ($request['limit'] != '') {
                $data = $data->skip(0)->take($request['limit']);
            }
            $data = $data->get();

            return response(VisitorResource::collection($data), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function show(Visitor $visitor)
    {
        try {
            return response(new VisitorResource($visitor), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function store(Request $request)
    {
//        $validator = Validator::make($request->all('title'),
//            [
//                'title' => 'required|unique:visitors,title',
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
            $visitor = Visitor::create($request->all());
            return response(new VisitorResource($visitor), 201);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function update(Request $request, Visitor $visitor)
    {
//        $validator = Validator::make($request->all('title'),
//            [
//                'title' => 'required|unique:visitors,title,' . $visitor['id'],
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
            $visitor->update($request->all());
            return response(new VisitorResource($visitor), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function destroy(Visitor $visitor)
    {
        try {
            $visitor->delete();
//TODO delete subsets.
            return response('Visitor deleted', 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function activeToggle(Visitor $visitor)
    {
        try {
            $visitor->update(['active' => !$visitor['active']]);
            return response(new VisitorResource($visitor), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }


}
