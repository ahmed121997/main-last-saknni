<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Model\Governorate;
use App\Model\ListView;
use App\Model\Property;
use App\Model\City;
use App\Model\TypeFinish;
use App\Model\TypePayment;
use App\Model\TypeProperty;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(){
        $list_views = ListView::select('id','list_'.app()->getLocale().' as type')->get();
        $type_properties = TypeProperty::select('id','type_'.app()->getLocale().' as type')->get();
        $type_finishes  = TypeFinish::select('id','type_'.app()->getLocale() . ' as type')->get();
        $type_payments = TypePayment::select('id','type_'.app()->getLocale() . ' as type')->get();
        $govs = Governorate::select('id','governorate_name_'.app()->getLocale() .' as governorate_name')->get();
        return view('search.search',compact(['list_views', 'type_finishes','type_properties', 'type_payments','govs']));
    }

    public function process(Request $request)
    {
        $city = $request->city;
        $type = $request->type_property;
        $finish = $request->type_finish;
        $pay = $request->type_payment;

        // 4
        if($city != '' && $type != '' && $finish != '' && $pay != '' ){
            $res  = $this->searchAlgorithm('city_id', $city, 'type_property_id', $type,'type_finish_id', $finish,'type_payment_id', $pay);
            return response()->json($res);
        }
        // 3
        elseif($city != '' && $type != '' && $finish != ''){
            $res  = $this->searchAlgorithm('city_id', $city, 'type_property_id', $type,'type_finish_id', $finish);
            return response()->json($res);
        }
        elseif($city != '' && $type != '' && $pay != ''){
            $res  = $this->searchAlgorithm('city_id', $city, 'type_property_id', $type,'type_payment_id', $pay);
            return response()->json($res);
        }
        if($city != '' && $finish != '' && $pay != '' ){
            $res  = $this->searchAlgorithm('city_id', $city,'type_finish_id', $finish,'type_payment_id', $pay);
            return response()->json($res);
        }
        if($type != '' && $finish != '' && $pay != '' ){
            $res  = $this->searchAlgorithm('type_property_id', $type,'type_finish_id', $finish,'type_payment_id', $pay);
            return response()->json($res);
        }

        // 2
        if($city != '' && $type != ''){
            $res  = $this->searchAlgorithm('city_id', $city, 'type_property_id', $type);
            return response()->json($res);
        }
        if($city != '' &&  $pay != '' ){
            $res  = $this->searchAlgorithm('city_id', $city, 'type_payment_id', $pay);
            return response()->json($res);
        }
        if( $type != '' && $finish != ''){
            $res  = $this->searchAlgorithm( 'type_property_id', $type,'type_finish_id', $finish);
            return response()->json($res);
        }
        if( $finish != '' && $pay != '' ){
            $res  = $this->searchAlgorithm('type_finish_id', $finish,'type_payment_id', $pay);
            return response()->json($res);
        }

        // 1
        elseif($city != ''){
            $res  = $this->searchAlgorithm('city_id', $city);
            return response()->json($res);
        }
        elseif($type != ''){
            $res  = $this->searchAlgorithm('type_property_id', $type);
            return response()->json($res);
        }
        elseif($pay != ''){
            $res  = $this->searchAlgorithm('type_payment_id', $pay);
            return response()->json($res);
        }
        elseif($finish != ''){
            $res  = $this->searchAlgorithm('type_finish_id', $finish);
            return response()->json($res);
        }


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
            $city_name = City::select('id','city_name_'.app()->getLocale() . ' as city_name')->find($request->city);
        }else{
            $city  = null ;
            $col_city = null;
            $city_name = null;
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
        if($sell_rent == 'rent'){
            $daily_monthly =  $request->daily_monthly;
            $col_daily_monthly = 'type_rent';
        }else{
            $daily_monthly =  null;
            $col_daily_monthly = null;
        }



        $properties  = $this->searchMainAlgorithm($col_sell_rent, $sell_rent,
            $col_city, $city,
            $col_type, $type,
            $col_pay, $pay,
            $col_daily_monthly,$daily_monthly,
            $col_price, $min_price,$col_price, $max_price,
            $col_area,$min_area,$col_area,$max_area);

        return view('search.mainSearch',compact(['properties','sell_rent','city_name','type_properties','type_payments','govs']));
    }



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
                ->where($col_5,$value_5)
                ->where($min_price,">",$value_6) //100
                ->where($max_price,"<",$value_7) // 400
                ->where($min_area,">",$value_8)
                ->where($max_area,"<",$value_9)
                ->get();

            foreach ($properties as $property){
                $property->images->source = unserialize($property->images->source);
                $property->favorite = $property->isFavorited();
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
                $property->favorite = $property->isFavorited();
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
                $property->favorite = $property->isFavorited();
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
                ->get();

            foreach ($properties as $property){
                $property->images->source = unserialize($property->images->source);
                $property->favorite = $property->isFavorited();
            }
            return $properties;
        }

    }
    private function searchAlgorithm($col_1, $value_1, $col_2 = null, $value_2 =null, $col_3 =null, $value_3 =null, $col_4 =null,$value_4 =null){
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
            ->get();

        foreach ($properties as $property){
            $property->images->source = unserialize($property->images->source);
            $property->favorite = $property->isFavorited();
        }
        return $properties;
    }



}
