<?php

namespace App\Http\Controllers\Api;
use App\Traits\GeneralApiTreat;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function __construct(){
        $this->middleware('auth:api');
    }
    //
    use GeneralApiTreat;
    public function update(Request $request){
        $res = User::find($request->id);
        if(!$res){
            return $this->responseError('E001',__('user not found !'));
        }
        try{

            if($res->email == $request->email){
                $validator  = Validator::make($request->all(), [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'phone' => 'digits_between:11,20',
                ]);
            }else{
                $validator  = Validator::make($request->all(), [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'phone' => 'digits_between:11,20'
                ]);
            }
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $res->update($request->all());
            return $this->responseSuccess('S001',__('user data is updated'));

        }catch (\Exception $ex){
            return $this->responseError($ex->getCode(), $ex->getMessage());
        }

    }
}
