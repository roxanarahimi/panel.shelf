<?php

namespace App\Http\Controllers;

use App\Http\Resources\FormResource;
use App\Models\Form;
use App\Models\FormSection;
use App\Models\FormSectionSku;
use App\Models\FormSku;
use App\Models\FormSkuCategory;
use App\Models\Sku;
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

              if (isset($request['date']) && $request['date'] !== ''){
                  $date = explode(',',$request['date']);
                  $data = Form::orderByDesc('id')->whereDate('created_at','>=',$date[0])
                      ->whereDate('created_at','<=',$date[1])->paginate($perPage);
              }else{
                  $data = Form::orderByDesc('id')->paginate($perPage);
              }

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
            $data = Form::orderBy('id')->where('visitor_id', $request['visitor_id'])->get();

            return response(FormResource::collection($data), 200);
//            return response(new FormResource($data), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function show(Form $form)
    {
        try {
            return response(new FormResource($form), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function getForms($id)
    {
        try {
            $forms = Form::orderByDesc('id')->where('visitor_id',$id)->take(50)->get();
            return response(FormResource::collection($forms), 200);
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
//        return ;
        try {
            $requestForm = json_decode($request['form'], true);
            $form = Form::create([
                'customer_id' => $request['customer_id'],
                'visitor_id' => $request['visitor_id'],
                'description' => $request['description'],
            ]);
            $i = 0;
            foreach ($requestForm as $section) {
                $formSection = FormSection::create([
                    'form_id' => $form['id'],

                    'sku_category_id' => $section['sku_category_id'],
                    'brand_id' => $section['brand_id'],

                    'space' => $section['space'],
                    'layout' => $section['layout'],

                ]);
                if ($request->file('image_' . $i)) {
                    $img = $request->file('image_' . $i);
                    $imageName = 'form_' . $form['id'] . '_section_' . $formSection['id'] . '_' . uniqid() . '.' . $img->extension();

                    $img->storeAs('/public/images', $imageName);;
                    $formSection->update(['image' => '/images/' . $imageName]);
                    (new ImageController)->resizeImage('/storage/app/public/images', $imageName);

                }
                foreach ($section['skus'] as $sku) {
                    FormSectionSku::create([
                        'form_section_id' => $formSection['id'],
                        'sku_id' => $sku['sku_id'],

                        'face' => $sku['face'],
                        'presence' => $sku['presence'],
                        'expire_date' => $sku['expire_date'],

                        'label_price' => $sku['label_price'],
                        'sale_price' => $sku['sale_price'],
                        'distribute_price' => $sku['distribute_price']
                    ]);
                }
                $i++;
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

