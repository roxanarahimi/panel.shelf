<?php

namespace App\Http\Controllers;

use App\Http\Resources\FormResource;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class FormController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request['perPage'];
            $data = Form::orderByDesc('id')
//                ->where('visitor_id', $request['visitor_id'] )
                ->paginate($perPage);
            $pages_count = ceil($data->total() / $perPage);
            $labels = [];
            for ($i = 1; $i <= $pages_count; $i++) {
                (array_push($labels, $i));
            }
            return response([
                "data" => FormResource::collection($data),
                "pages" => $pages_count,
                "total" => $data->total(),
                "labels" => $labels,
                "title" => 'فرم ها',
                "tooltip_new" => 'ثبت فرم جدید',
            ], 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function indexSite(Request $request)
    {
        try {
            $data = Form::orderBy('id')->where('visitor_id', $request['visitor_id'] )->get();

            return response(FormResource::collection($data), 200);
//            return response(new FormResource($data), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }
    public function show(Form $form)
    {
        try {
            return response( new FormResource($form), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function saveImages($requestImages, $formId)
    {
        try {
            $images = '';
            for ($i = 0; $i < count($requestImages); $i++) {
                if ($requestImages[$i][1]) {
                    $name = 'form_' . $formId . '_' . uniqid() . '.png';
                    $image_path = (new ImageController)->uploadImage($requestImages[$i][1], $name, 'images/');
//                    (new ImageController)->resizeImage('images/', $name);
                    $images = $images . '/' . $image_path . ',';
                } else if ($requestImages[$i][0]) {
                    $images = $images . $requestImages[$i][0] . ',';
                }
            }
            return $images;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function store(Request $request)
    {
//        $validator = Validator::make($request->all('title'),
//            [
//                'title' => 'required|unique:forms,title',
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
            return $request;
//            'sku_category_id',
//            'brand_id',
//             'sku_ids',
            $form = Form::create([
            'face'=>$request['face'],
            'presence'=>$request['presence'],
            'expire_date'=>$request['expire_date'],
            'label_price'=>$request['label_price'],
            'sale_price'=>$request['sale_price'],
            'distribute_price'=>$request['distribute_price']
            ]);

            if ($request['image']) {
                $name = 'form_' . $form['id'] . '_' . uniqid() . '.png';
                $image_path = (new ImageController)->uploadImage($request['image'], $name, 'images/forms/');
                $form->update(['image' => '/' . $image_path]);

                (new ImageController)->resizeImage('images/forms/', $name);
            }

            return response(new FormResource($form), 201);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function update(Request $request, Form $form)
    {
//        $validator = Validator::make($request->all('title'),
//            [
//                'title' => 'required|unique:forms,title,' . $form['id'],
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
            $form->update($request->all());
            return response(new FormResource($form), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function sort(Request $request, Form $form)
    {
//        $validator = Validator::make($request->all('title'),
//            [
//                'title' => 'required|unique:forms,title,' . $form['id'],
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
            $form->update($request->all('index'));
            return response(new FormResource($form), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function destroy(Form $form)
    {

        try {
            if ($form['image']) {
                $file_to_delete = ltrim($form['image'], $form['image'][0]); //remove '/' from file name start
                $file_to_delete_thumb = ltrim(str_replace('.png', '_thumb.png', $file_to_delete));
                if (file_exists($file_to_delete)) {
                    unlink($file_to_delete);
                }
                if (file_exists($file_to_delete_thumb)) {
                    unlink($file_to_delete_thumb);
                }
            }
            $form->delete();
            return response('form deleted', 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function activeToggle(Form $form)
    {
        try {
            $form->update(['active' => !$form['active']]);
            return response(new FormResource($form), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function updateOrder(Request $request, Form $form)
    {
        try {
            $form->update(['images' => substr($request['images'], 0, -1)]);
            return response(new FormResource($form), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function byCatPanel($id)
    {
        try {
            $data = Form::orderBy('title')->where('form_category_id', $id)->where('active', 1)->get();
            return response(["data" => FormResource::collection($data)], 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function byCat($id)
    {
        try {
            $data = Form::orderBy('id')->where('form_category_id', $id)->where('active', 1)->get();
            foreach ($data as $item) {
                $thumb2 = $item->image ? str_replace('.png', '_thumb.png', $item->image) : '';
                $item->thumb = $thumb2;
            }
            return response([
                "data" => $data,
            ], 200);
        } catch (\Exception $exception) {
            return response($exception);

        }
    }

    public function fix(Request $request)
    {
        $x = DB::connection()->getDatabaseName();
        return $x;
    }
}

