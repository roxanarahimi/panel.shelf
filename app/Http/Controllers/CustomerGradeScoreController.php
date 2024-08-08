<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerGradeScoreResource;
use App\Models\CustomerGradeScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerGradeScoreController extends Controller
{


    public function index(Request $request)
    {
        try {
            $perPage = $request['perPage'];
            $data = CustomerGradeScore::orderByDesc('id')
//                ->where('code', 'Like', '%' . $request['search'] . '%')
                ->paginate($perPage);
            $pages_count = ceil($data->total() / $perPage);
            $labels = [];
            for ($i = 1; $i <= $pages_count; $i++) {
                (array_push($labels, $i));
            }
            return response([
                "data" => CustomerGradeScoreResource::collection($data),
                "pages" => $pages_count,
                "total" => $data->total(),
                "labels" => $labels,
                "title" => 'مشتری ها',
                "tooltip_new" => 'ثبت مشتری جدید',
            ], 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function indexSite(Request $request)
    {
        try {
            $data = CustomerGradeScore::orderByDesc('id')->where('active', 1);
            if ($request['search'] != '') {
                $data = $data->where('name', 'Like', '%' . $request['search'] . '%');
            }
            if ($request['limit'] != '') {
                $data = $data->skip(0)->take($request['limit']);
            }
            $data = $data->get();

            return response(CustomerGradeScoreResource::collection($data), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function show(CustomerGradeScore $customerGradeScore)
    {
        try {
            return response(new CustomerGradeScoreResource($customerGradeScore), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function store(Request $request)
    {
//        $validator = Validator::make($request->all('title'),
//            [
//                'title' => 'required|unique:customerGradeScores,title',
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
            $customerGradeScore = CustomerGradeScore::create($request->all());
            return response(new CustomerGradeScoreResource($customerGradeScore), 201);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function update(Request $request, CustomerGradeScore $customerGradeScore)
    {
//        $validator = Validator::make($request->all('title'),
//            [
//                'title' => 'required|unique:CustomerGradeScores,title,' . $customerGradeScore['id'],
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
            $customerGradeScore->update($request->all());
            return response(new CustomerGradeScoreResource($customerGradeScore), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function destroy(CustomerGradeScore $customerGradeScore)
    {
        try {
            $customerGradeScore->delete();
//TODO delete subsets.
            return response('CustomerGradeScore deleted', 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function activeToggle(CustomerGradeScore $customerGradeScore)
    {
        try {
            $customerGradeScore->update(['active' => !$customerGradeScore['active']]);
            return response(new CustomerGradeScoreResource($customerGradeScore), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }
    public function bySector($id)
    {
        try {
            $dataa = CustomerGradeScore::where('sector_id',$id)->get();
            return response(CustomerGradeScoreResource::collection($dataa), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }
    public function byCode($code)
    {
        try {
            $dataa = CustomerGradeScore::where('code',$code)->first();
            return response(new CustomerGradeScoreResource($dataa), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }



}
