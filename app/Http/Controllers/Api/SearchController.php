<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Governorate;
use App\Model\ListView;
use App\Model\Property;
use App\Model\TypeFinish;
use App\Model\TypePayment;
use App\Model\TypeProperty;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;
use App\Traits\GeneralApiTreat;

class SearchController extends Controller
{
    use GeneralApiTreat;
    public function index(){
        $list_views = ListView::select('id','list_'.app()->getLocale().' as type')->get();
        $type_properties = TypeProperty::select('id','type_'.app()->getLocale().' as type')->get();
        $type_finishes  = TypeFinish::select('id','type_'.app()->getLocale() . ' as type')->get();
        $type_payments = TypePayment::select('id','type_'.app()->getLocale() . ' as type')->get();
        $govs = Governorate::select('id','governorate_name_'.app()->getLocale() .' as governorate_name')->get();
        return view('search',compact(['list_views', 'type_finishes','type_properties', 'type_payments','govs']));
    }


    public function mainSearch(Request $request){

        $type_properties = TypeProperty::select('id','type_'.app()->getLocale() .' as type')->get();
        $type_payments = TypePayment::select('id','type_'.app()->getLocale() .' as type')->get();
        $govs = Governorate::select('id','governorate_name_'.app()->getLocale() .' as governorate_name')->get();

        if($request->sell_rent != ''){
            $sell_rent  = $request->sell_rent ;
            $col_sell_rent = 'list_section';
        }else{
            $sell_rent  = null ;
            $col_sell_rent = null;
        }
        if($request->city != ''){
            $city  = $request->city ;
            $col_city = 'city_id';
        }else{
            $city  = null ;
            $col_city = null;
        }

        if($request->type_property != ''){
            $type  = $request->type_property;
            $col_type = 'type_property_id';
        }else{
            $type  = null;
            $col_type = null;
        }
        if($request->type_pay != ''){
            $pay  = $request->type_pay;
            $col_pay = 'type_payment_id';
        }else{
            $pay  = null;
            $col_pay = null ;
        }

        if($request->min_price != '' && $request->max_price != ''){
            $min_price =   $request->min_price;
            $max_price =   $request->max_price;
            $col_price = 'price';
        }else{
            $min_price =   null;
            $max_price =  null;
            $col_price = null;
        }


        if($request->min_area != '' && $request->max_area != ''){
            $min_area =    $request->min_area;
            $max_area =   $request->max_area;
            $col_area = 'area';
        }else{
            $min_area =   null;
            $max_area =  null;
            $col_area = null;
        }


        $properties  = $this->searchMainAlgorithm($col_sell_rent, $sell_rent,
            $col_city, $city,
            $col_type, $type,
            $col_pay, $pay,
            $col_price, $min_price,$col_price, $max_price,
            $col_area,$min_area,$col_area,$max_area);

        return $this->responseWithData('data', $properties);    }



    private function searchMainAlgorithm($col_1, $value_1, $col_2 = null, $value_2 =null, $col_3 =null,
                                         $value_3 =null, $col_4 =null,$value_4 =null,$col_5=null,$value_5=null,
                                         $min_price =null, $value_6 =null,$max_price=null,$value_7=null,$min_area=null,
                                         $value_8=null,$max_area=null,$value_9=null){
        if($min_price != null && $max_price != null && $min_area != null && $max_area){
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
                'city'=> function($q){
                    $q->select('id','city_name_'.app()->getLocale().' as city_name');
                }
            ])->where($col_1,$value_1)
                ->where($col_2,$value_2)
                ->where($col_3,$value_3)
                ->where($col_4,$value_4)
                ->where($min_price,">",$value_6) //100
                ->where($max_price,"<",$value_7) // 400
                ->where($min_area,">",$value_8)
                ->where($max_area,"<",$value_9)
                ->get();

            foreach ($properties as $property){
                $property->images->source = unserialize($property->images->source);
            }
            return $properties;
        }elseif ($min_price != null && $max_price != null){
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
                'city'=> function($q){
                    $q->select('id','city_name_'.app()->getLocale().' as city_name');
                }
            ])->where($col_1,$value_1)
                ->where($col_2,$value_2)
                ->where($col_3,$value_3)
                ->where($col_4,$value_4)
                ->where($col_5,$value_5)
                ->where($min_price,">",$value_6) //100
                ->where($max_price,"<",$value_7) // 400
                ->get();

            foreach ($properties as $property){
                $property->images->source = unserialize($property->images->source);
            }
            return $properties;
        }elseif ($min_area != null && $max_area){
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
                'city'=> function($q){
                    $q->select('id','city_name_'.app()->getLocale().' as city_name');
                }
            ])->where($col_1,$value_1)
                ->where($col_2,$value_2)
                ->where($col_3,$value_3)
                ->where($col_4,$value_4)
                ->where($col_5,$value_5)
                ->where($min_area,">",$value_8)
                ->where($max_area,"<",$value_9)
                ->get();

            foreach ($properties as $property){
                $property->images->source = unserialize($property->images->source);
            }
            return $properties;
        }else{
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
                'city'=> function($q){
                    $q->select('id','city_name_'.app()->getLocale().' as city_name');
                }
            ])->where($col_1,$value_1)
                ->where($col_2,$value_2)
                ->where($col_3,$value_3)
                ->where($col_4,$value_4)
                ->where($col_5,$value_5)
                ->paginate(ENV('PAGINATION_COUNT','20'));

            foreach ($properties as $property){
                $property->images->source = unserialize($property->images->source);
            }
            return $properties;
        }

    }

}
