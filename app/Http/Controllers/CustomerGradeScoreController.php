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

    public function show(CustomerGradeScore $customerGradeScore)
    {
        try {
            return response(new CustomerGradeScoreResource($customerGradeScore), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function update(Request $request)
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
            $score = CustomerGradeScore::where('customer_id', $request['customer_id'])->first();
            if ($score) {
                $score->update([
                    "sector_id" => $request['sector_id'],
                    "meterage" => $request['meterage'],
                    "product_variety" => $request['product_variety'],
                    "product_layout" => $request['product_layout'],
                    "equipment" => $request['equipment'],
                ]);
            } else {
                $score = CustomerGradeScore::create([
                    "customer_id" => $request['customer_id'],
                    "sector_id" => $request['sector_id'],
                    "meterage" => $request['meterage'],
                    "product_variety" => $request['product_variety'],
                    "product_layout" => $request['product_layout'],
                    "equipment" => $request['equipment'],
                ]);
            }
            return response(new CustomerGradeScoreResource($score), 201);

        } catch (\Exception $exception) {
            return response($exception);
        }
    }



}
