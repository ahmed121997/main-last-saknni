<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PropertyRequest;
use App\Model\DescriptionProperty;
use App\Model\Governorate;
use App\Model\Image;
use App\Model\ListView;
use App\Model\Property;
use App\Model\TypeFinish;
use App\Model\TypePayment;
use App\Model\TypeProperty;
use App\Traits\GeneralApiTreat;
use App\Traits\SaveImages;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api')->except(['index','getCities','showAllProperties','allSpecial']);
    }

    // traits
    use GeneralApiTreat;
    use SaveImages;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){
        try {
            $property = Property::with(['images', 'des',
                'typeProperty' => function ($q) {
                    $q->select('id', 'type_' . app()->getLocale() . ' as type');
                },
                'view' => function ($q) {
                    $q->select('id', 'list_' . app()->getLocale() . ' as list');
                },
                'finish' => function ($q) {
                    $q->select('id', 'type_' . app()->getLocale() . ' as type');
                },
                'city' => function ($q) {
                    $q->select('id', 'city_name_' . app()->getLocale() . ' as city_name');
                },
                'payment', 'user', 'comments'])->find($request->id);
            if (!$property)
                return $this->responseError('E001', __('property_id_not_found'));
            $property->images->source = unserialize($property->images->source);
            return $this->responseWithData('data', $property);
        }catch (\Exception $ex){
            return $this->responseError($ex->getCode(), $ex->getMessage());
        }
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(){
        $list_views = ListView::select('id','list_'.app()->getLocale().' as list')->get();
        $type_properties = TypeProperty::select('id','type_'.app()->getLocale() .' as type')->get();
        $type_finishes  = TypeFinish::select('id','type_'.app()->getLocale() .' as type')->get();
        $type_payments = TypePayment::select('id','type_'.app()->getLocale() .' as type')->get();
        $govs = Governorate::select('id','governorate_name_'.app()->getLocale() .' as governorate_name')->get();

        return $this->responseWithData('data',['list_views'=> $list_views,
                                                    'type_finish'=> $type_finishes,
                                                    'type_property'=> $type_properties,
                                                    'type_payment' =>$type_payments,
                                                    'govs'=> $govs
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    // store property
    public function store(Request $request){

        try {
            $validator = Validator::make($request->all(), $this->rules());

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $images = $this->saveMultipleImages($request, 'images');

            $res = Property::create([
                'user_id' => $request->user_id,
                'type_property_id' => $request->type_property,
                'list_section' => $request->list_section,
                'area' => $request->area,
                'city_id' => $request->city,
                'num_bathroom' => $request->bathroom,
                'num_rooms' => $request->rooms,
                'list_view_id' => $request->list_view,
                'num_floor' => $request->floor,
                'type_finish_id' => $request->type_finish,
                'location' => $request->location,
                'type_payment_id' => $request->type_pay,
                'price' => $request->price,
                'link_youtube' => $request->link_youtube,
            ]);
            $res->save();
            $id = $res->id;
            /// add Details for property
            $properties = Property::find($id);
            $des = new DescriptionProperty;
            $des->title = $request->title;
            $des->details = $request->details;
            $properties->des()->save($des);

            $img = new Image;
            $img->source = serialize($images);
            $properties->images()->save($img);

            if (!$res && !$des && !$img) {
                return $this->responseError('E001', __('property.fail_to_add_property'));
            }
            return $this->responseSuccess('S001', __('property.property_added_successfully!'));
        }catch (\Exception $ex){
            return $this->responseError($ex->getCode(), $ex->getMessage());
        }
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    // Edit Property
    public function edit(Request $request){
        try{
            $property = Property::with(['city'=> function($q){
                $q->select('id','gov_id','city_name_'.app()->getLocale().' as city_name');
            },
                'des','images'])->find($request->id);

            if(!$property)
                return $this->responseError('E001',__('property.property_id_not_found'));

            $cities = Governorate::with(['cities'=>function($q){
                $q->select('id','city_name_'.app()->getLocale(). ' as city_name');
            }])->find($property->city->gov_id);

            $list_views = ListView::select('id','list_'.app()->getLocale() .' as list')->get();
            $type_properties = TypeProperty::select('id','type_'.app()->getLocale() .' as type')->get();
            $type_finishes  = TypeFinish::select('id','type_'.app()->getLocale() .' as type')->get();
            $type_payments = TypePayment::select('id','type_'.app()->getLocale() .' as type')->get();
            $govs = Governorate::select('id','governorate_name_'.app()->getLocale() .' as governorate_name')->get();

            return $this->responseWithData('data',[
                'property' => $property,
                'list_views'=> $list_views,
                'type_finish'=> $type_finishes,
                'type_property'=> $type_properties,
                'type_payment' =>$type_payments,
                'govs'=> $govs,
                'cities' =>$cities,
            ]);
        }catch (\Exception $ex){
            return $this->responseError($ex->getCode(), $ex->getMessage());
        }

    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    // update property
    public function update(Request $request){
        try {
            $res = Property::find($request->id);
            $res_des = DescriptionProperty::find($request->id_des);
            if (!$res && !$res_des)
                return $this->responseError('E001', __('property.property_id_not_found'));

            $validator = Validator::make($request->all(), $this->rules());

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $des = $res_des->update([
                'title' => $request->title,
                'details' => $request->details,
            ]);
            $res = $res->update([
                'type_property_id' => $request->type_property,
                'list_section' => $request->list_section,
                'area' => $request->area,
                'city_id' => $request->city,
                'num_bathroom' => $request->bathroom,
                'num_rooms' => $request->rooms,
                'list_view_id' => $request->list_view,
                'num_floor' => $request->floor,
                'type_finish_id' => $request->type_finish,
                'location' => $request->location,
                'type_payment_id' => $request->type_pay,
                'price' => $request->price,
                'link_youtube' => $request->link_youtube,
            ]);

            if (!$res && !$des) {
                return $this->responseError('E001', __('property.fail_to_update_property'));
            }
            return $this->responseSuccess('S001', __('property.update_successfully!'));
        }catch (\Exception $ex){
            return $this->responseError($ex->getCode(), $ex->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id){
        try {
            $property = Property::find($id);
            if (!$property)
                return $this->responseError('E001', __('property.property_id_not_found'));
            $images = Image::where('property_id', $id)->first();
            $files = $images->source = unserialize($images->source);
            for ($i = 0; $i < count($files); $i++) {
                $files[$i] = public_path() . '/images/' . $files[$i];
            }
            $files = File::delete($files);
            $images->delete();
            $des = DescriptionProperty::where('property_id', $id)->first();
            $des->delete();
            $property->delete();
            if (!$property) {
                return $this->responseError('E001', __('property.fail_to_delete_property'));
            }
            return $this->responseSuccess('S001', __('property.delete_successfully!'));
        }catch (\Exception $ex){
            return $this->responseError($ex->getCode(), $ex->getMessage());

        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAllProperties(){
        try {

            $properties = Property::with(['des','user'=>function ($q) {
                $q->select('id','phone','name');
            },'images',
                'typeProperty' => function ($q) {
                    $q->select('id', 'type_' . app()->getLocale() . ' as type');
                },
                'view' => function ($q) {
                    $q->select('id', 'list_' . app()->getLocale() . ' as list');
                },
                'finish' => function ($q) {
                    $q->select('id', 'type_' . app()->getLocale() . ' as type');
                },
                'payment' => function ($q) {
                    $q->select('id', 'type_' . app()->getLocale() . ' as type');
                },
                'city' => function ($q) {
                    $q->select('id', 'city_name_' . app()->getLocale() . ' as city_name');
                }
            ])->paginate(PAGINATION_COUNT);

            foreach ($properties as $property) {
                $property->images->source = unserialize($property->images->source);
            }

            return $this->responseWithData('data', $properties);
        }catch (\Exception $ex){
            return $this->responseError($ex->getCode(), $ex->getMessage());
        }
    }


    public function allSpecial(){
        try {
            $properties = Property::with(['des', 'user' => function ($q) {
                $q->select('id', 'phone', 'name');
            },
                'images',
                'typeProperty' => function ($q) {
                    $q->select('id', 'type_' . app()->getLocale() . ' as type');
                },
                'view' => function ($q) {
                    $q->select('id', 'list_' . app()->getLocale() . ' as list');
                },
                'finish' => function ($q) {
                    $q->select('id', 'type_' . app()->getLocale() . ' as type');
                },
                'payment' => function ($q) {
                    $q->select('id', 'type_' . app()->getLocale() . ' as type');
                },
                'city' => function ($q) {
                    $q->select('id', 'city_name_' . app()->getLocale() . ' as city_name');
                }
            ])->where('special', '=', 1)->orderByDesc('created_at')->paginate(PAGINATION_COUNT);

            foreach ($properties as $property) {
                $property->images->source = unserialize($property->images->source);
            }

            return $this->responseWithData('data', $properties);
        }catch (\Exception $ex){
            return $this->responseError($ex->getCode(), $ex->getMessage());
        }
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    // get cities by id gov
    public function getCities(Request $request){
        try {
            $govs = Governorate::with(['cities'=>function($q){
                $q->select('id','gov_id','city_name_'.app()->getLocale().' as city_name');
            }])->find($request->id);
            if (!$govs) {
                return $this->responseError('E001', 'property.not_found_id');
            }
            return $this->responseWithData('cities', $govs);
        }catch (\Exception $ex){
            return $this->responseError($ex->getCode(), $ex->getMessage());
        }
    }

    private function rules(){
        return  [
            'type_property'=> 'required|numeric',
            'list_section'=> 'required|string',
            'area'=> 'required|numeric|min:40|max:5000',
            'city' =>'required|numeric',
            'bathroom'=>'required|numeric|min:1|max:50',
            'rooms'=>'required|numeric|min:1|max:200',
            'list_view'=>'required|numeric',
            'floor'=> 'required|numeric|min:0|max:100',
            'type_finish'=> 'required|numeric',
            'location'=> 'required|string',
            'type_pay'=>'required|numeric',
            'price'=>'required|numeric',
            'link_youtube'=>'required',
            'title'=>'required:string|max:255',
            'details'=>'required:string',
        ];
    }
}
