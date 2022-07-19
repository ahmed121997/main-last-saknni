<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Model\Property;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public function activation($id){

        if(request('id') && request('resourcePath')){
            $payment_status = $this->getPaymentStatus(request('id'),request('resourcePath'));
            if(isset($payment_status['id'])){
                $success_payment = true;

                $property = Property::findorfail($id);
                $property->update([
                    'status'=> 1,
                    'trans_payment_id'=>$payment_status['id'],
                ]);
                return view('property.activation')->with(['id'=>$id,'success_payment' =>'تم الدفع بنجاح']);
            }else{
                $fail_payment = true;
                return view('property.activation')->with(['id'=>$id,'fail_payment'=>'فشل الدفع']);
            }

        }
        return view('property.activation')->with(['id'=>$id]);
    }

    public function getCheckId(Request $request){
        $url = "https://test.oppwa.com/v1/checkouts";
        $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
            "&amount=10.00" .
            "&currency=EUR" .
            "&paymentType=DB";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $res = json_decode($responseData, true);
        $view = view('property.payForm')->with(['res'=>$res,'id' =>$request->id])->renderSections();

        return response()->json([
           'status' => true,
            'content' =>$view['main'],
        ]);

    }

    private function getPaymentStatus($id,$resourcePath){
        $url = "https://test.oppwa.com/v1/checkouts/".$id."/payment";
        $url .= "?entityId=8a8294174b7ecb28014b9699220015ca";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }
}
