<?php

namespace App\Http\Controllers;


use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request['perPage'];
            $data = Customer::orderBy('id')
                ->where('code', 'Like', '%' . $request['search'] . '%')->paginate($perPage);
            $pages_count = ceil($data->total() / $perPage);
            $labels = [];
            for ($i = 1; $i <= $pages_count; $i++) {
                (array_push($labels, $i));
            }
            return response([
                "data" => CustomerResource::collection($data),
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
            $data = Customer::orderByDesc('id')->where('active', 1);
            if ($request['search'] != '') {
                $data = $data->where('name', 'Like', '%' . $request['search'] . '%');
            }
            if ($request['limit'] != '') {
                $data = $data->skip(0)->take($request['limit']);
            }
            $data = $data->get();

            return response(CustomerResource::collection($data), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function show(Customer $customer)
    {
        try {
            return response(new CustomerResource($customer), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function store(Request $request)
    {
//        $validator = Validator::make($request->all('title'),
//            [
//                'title' => 'required|unique:customers,title',
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
            $customer = Customer::create($request->all());
            return response(new CustomerResource($customer), 201);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function update(Request $request, Customer $customer)
    {
//        $validator = Validator::make($request->all('title'),
//            [
//                'title' => 'required|unique:Customers,title,' . $customer['id'],
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
            $customer->update($request->all());
            return response(new CustomerResource($customer), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
//TODO delete subsets.
            return response('Customer deleted', 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function activeToggle(Customer $customer)
    {
        try {
            $customer->update(['active' => !$customer['active']]);
            return response(new CustomerResource($customer), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }
    public function byRegion($id)
    {
        try {
            $dataa = Customer::where('region_id',$id)->get();
            return response(CustomerResource::collection($dataa), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }
public function byCode($code)
    {
        try {
            $dataa = Customer::where('code',$code)->first();
            return response(new CustomerResource($dataa), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }


}
