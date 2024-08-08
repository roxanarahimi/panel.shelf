<?php

namespace App\Http\Controllers;

use App\Http\Resources\VisitorResource;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request['perPage'];
            $data = Visitor::orderByDesc('id')
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
            $data = Visitor::orderByDesc('id')->where('active', 1);
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
            $v = Visitor::where('mobile',$request['mobile'])->first();
            if ($v){

                return response(["mobile" =>['این شماره قبلا عضو شده']],422);
            }
            $visitor = Visitor::create([
                'name'=> $request['name'],
                'mobile'=> $request['mobile'],
                'password'=> Hash::make($request['mobile']),
            ]);
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
            $v = Visitor::where('mobile',$request['mobile'])->whereNot('id',$visitor['id'])->first();
            if ($v){
                return response(['mobile'=>['این شماره برای کارشناس دیگری ثبت شده']],422);
            }
            $visitor->update([
                'name'=> $request['name'],
                'mobile'=> $request['mobile'],
//                'password'=> Hash::make($request['mobile']),
            ]);
            return response(new VisitorResource($visitor), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }
    public function updatePassword(Request $request, Visitor $visitor)
    {
        try {
            $visitor->update([
                'password'=> Hash::make($request['password']),
            ]);
            return response(new VisitorResource($visitor), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:3',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        try {
            $user = Visitor::where('mobile', $request->username)->first();
            if ($user) {
                if (Hash::check($request['password'],$user['password'])) {
                    return response(['user' => new VisitorResource($user)], 200);
                } else {
                    $response = ["password" => ["کلمه عبور اشتباه است"]];
                    return response($response, 422);
                }
            } else {
                $response = ["mobile" =>['کاربر وجود ندارد']];
                return response($response, 422);
            }
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
