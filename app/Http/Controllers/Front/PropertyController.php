<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Model\Governorate;
use App\Model\Image;
use App\Model\Property;
use App\Model\TypeFinish;
use App\Model\TypePayment;
use App\Model\TypeProperty;
use Illuminate\Http\Request;
use App\Model\DescriptionProperty;
use App\Model\ListView;
use App\Traits\SaveImages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index','getCities', 'showAllProperties');
    }

    use SaveImages;

    /***
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id){
        $properties = Property::with(['images','des',
            'typeProperty'=> function($q){
            $q->select('id','type_'.app()->getLocale().' as type');
        },
            'view'=> function($q){
            $q->select('id','list_'.app()->getLocale().' as list');
        },
            'finish'=> function($q){
            $q->select('id','type_'.app()->getLocale().' as type');
        },
            'city'=> function($q){
                $q->select('id','city_name_'.app()->getLocale().' as city_name');
            },
            'payment','user','comments'])->findorfail($id);

        $properties->images->source = unserialize($properties->images->source);
        return view('property.show',compact(['properties']));
    }

    /***
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        $list_views = ListView::select('id','list_'.app()->getLocale() .' as list')->get();
        $type_properties = TypeProperty::select('id','type_'.app()->getLocale() .' as type')->get();
        $type_finishes  = TypeFinish::select('id','type_'.app()->getLocale() .' as type')->get();
        $type_payments = TypePayment::select('id','type_'.app()->getLocale() .' as type')->get();
        $govs = Governorate::select('id','governorate_name_'.app()->getLocale() .' as governorate_name')->get();
        return view('property.create',compact(['list_views', 'type_finishes','type_properties', 'type_payments','govs']));
    }

    /***
     * @param PropertyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){

        $validator = Validator::make($request->all(), $this->rules());
        if($validator->fails()) {
            return back()->withErrors($validator);
        }
        $images = $this->saveMultipleImages($request,'images');
        $res = Property::create([
            'user_id'=> Auth::user()->id,
            'type_property_id'=> $request->typeProperty,
            'list_section'=> $request->listSection,
            'type_rent'=> $request->type_rent,
            'area'=> $request->area,
            'city_id' =>$request->city,
            'num_bathroom'=>$request->bathroom,
            'num_rooms'=>$request->rooms,
            'list_view_id'=>$request->listView,
            'num_floor'=> $request->floor,
            'type_finish_id'=> $request->typeFinish,
            'location'=> $request->location,
            'type_payment_id'=>$request->typePay,
            'price'=>$request->price,
            'link_youtube'=>$request->linkYoutube,
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
        if(!$res && !$des && !$img){
            return redirect()->back()->with('fail_add',__('property.fail_to_add_property'));
        }
        return redirect()->back()->with('success_add',__('property.property_added_successfully!'));
    }

    public function edit($id){
        $properties = Property::with('city','des','images')->findOrFail($id);

        $cities = Governorate::find($properties->city->gov_id)->cities;
        $list_views = ListView::select('id','list_'.app()->getLocale() .' as list')->get();
        $type_properties = TypeProperty::select('id','type_'.app()->getLocale() .' as type')->get();
        $type_finishes  = TypeFinish::select('id','type_'.app()->getLocale() .' as type')->get();
        $type_payments = TypePayment::select('id','type_'.app()->getLocale() .' as type')->get();
        $govs = Governorate::select('id','governorate_name_'.app()->getLocale() .' as governorate_name')->get();
        return view('property.edit',compact(['properties','cities','list_views', 'type_finishes','type_properties', 'type_payments','govs']));
    }

    /***
     * @param PropertyRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request){

        $validator = Validator::make($request->all(), $this->rules());
        if($validator->fails()) {
            return back()->withErrors($validator);
        }
        $res = Property::findorfail($request->id);
       $res_des = DescriptionProperty::findorfail($request->id_des);
       $res_des->update([
            'title'=>$request->title,
            'details'=>$request->details,
       ]);
       $res->update([
           'type_property_id'=> $request->typeProperty,
           'list_section'=> $request->listSection,
           'type_rent'=> $request->type_rent,
           'area'=> $request->area,
           'city_id' =>$request->city,
           'num_bathroom'=>$request->bathroom,
           'num_rooms'=>$request->rooms,
           'list_view_id'=>$request->listView,
           'num_floor'=> $request->floor,
           'type_finish_id'=> $request->typeFinish,
           'location'=> $request->location,
           'type_payment_id'=>$request->typePay,
           'price'=>$request->price,
           'link_youtube'=>$request->linkYoutube,
       ]);
       return redirect('user')->with('success_update',__('property.property_updated_successfully!'));
    }

    public function delete($id){
            $property = Property::findorfail($id);
            $images = Image::where('property_id',$id)->first();
            $files = $images->source = unserialize($images->source);
            for($i=0;$i < count($files);$i++){
                $files[$i] = public_path().'/images/'. $files[$i];
            }
            $files = File::delete($files);
            $images->delete();
            $des = DescriptionProperty::where('property_id',$id)->first();
            $des->delete();
            $property->delete();
            if(!$property){
                return back()->with(['message'=>'can not delete property']);
            }
            return back()->with(['message' => 'delete successfully !']);

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAllProperties(){
        $properties = Property::with(['des',
            'images',
            'typeProperty'=> function($q){
            $q->select('id','type_'.app()->getLocale().' as type');
        },
            'view'=> function($q){
            $q->select('id','list_'.app()->getLocale().' as list');
        },
            'finish'=> function($q){
            $q->select('id','type_'.app()->getLocale().' as type');
        },
            'payment'=>function($q){
            $q->select('id','type_'.app()->getLocale().' as type');
        },
            'city'=> function($q){
            $q->select('id','city_name_'.app()->getLocale().' as city_name');
        }
        ])->paginate(PAGINATION_COUNT);

        foreach ($properties as $property){
            $property->images->source = unserialize($property->images->source);
            $property->favorite = $property->isFavorited();
        }
        return view('property.showAll',compact('properties'));
    }

    ///////////////////////////////////////////////////////////////
    public function getCities(Request $request){
        $govs = Governorate::with(['cities'=>function($q){
            $q->select('id','gov_id','city_name_'.app()->getLocale(). ' as city_name');
        }])->find($request->id);
        if(!$govs){
            return response()->json('mgs','not found');
        }
        return $govs->cities;
    }

    public function favorite(Request $request){
        $property = Property::find($request->id);
        $property->toggleFavorite();
    }


    private function rules()
    {
        return [
            'typeProperty'=> 'required|numeric',
            'listSection'=> 'required|string',
            'area'=> 'required|numeric|min:40|max:5000',
            'city' =>'required|numeric',
            'bathroom'=>'required|numeric|min:1|max:50',
            'rooms'=>'required|numeric|min:1|max:100',
            'listView'=>'required|numeric',
            'floor'=> 'required|numeric|min:0|max:100',
            'typeFinish'=> 'required|numeric',
            'location'=> 'required|string',
            'typePay'=>'required|numeric',
            'price'=>'required|numeric',
            'linkYoutube'=>'required',
            'title'=>'required:string|max:255',
            'details'=>'required:string',
        ];
    }
}
