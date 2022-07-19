<?php
namespace App\Http\Controllers\Front;


use App\Http\Controllers\Controller;
use App\Model\Governorate;
use App\Model\ListView;
use App\Model\Property;
use App\Model\TypeFinish;
use App\Model\TypePayment;
use App\Model\TypeProperty;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //
    public function index(){
        $type_properties = TypeProperty::select('id','type_'.app()->getLocale() .' as type')->get();
        $type_payments = TypePayment::select('id','type_'.app()->getLocale() .' as type')->get();
        $govs = Governorate::select('id','governorate_name_'.app()->getLocale() .' as governorate_name')->get();


        // return 6 special property
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
            'payment'=> function($q){
                $q->select('id','type_'.app()->getLocale().' as type');
            },
            'city'=> function($q){
                $q->select('id','city_name_'.app()->getLocale().' as city_name');
            }
        ])->where('special', '=',1)->limit(6)->orderByDesc('created_at')->get();

        foreach ($properties as $property){
            $property->images->source = unserialize($property->images->source);
            $property->favorite = $property->isFavorited();
        }
        return view('welcome',compact(['properties','type_properties','type_payments','govs']));
    }


    /***
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allSpecial(){
        // return 3 special property
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
            'payment'=> function($q){
                $q->select('id','type_'.app()->getLocale().' as type');
            },
            'city'=> function($q){
                $q->select('id','city_name_'.app()->getLocale().' as city_name');
            }
        ])->where('special', '=',1)->orderByDesc('created_at')->paginate(20);

        foreach ($properties as $property){
            $property->images->source = unserialize($property->images->source);
            $property->favorite = $property->isFavorited();
        }
        return view('property.allSpecial',compact('properties'));
    }
}
