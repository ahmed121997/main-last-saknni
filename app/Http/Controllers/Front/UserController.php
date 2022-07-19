<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// Models
use App\Model\Property;
use App\User;


class UserController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
    }
    /***********************
    ** function index user 
    ** return view (user's properties)
    ** no parameters
    ** 
    */

    public function index(){
        $id= Auth::user()->id;
        $properties = Property::with(['des','typeProperty','view','finish','payment'])->where('user_id',$id)->get();
        $not_active = 0; // counter to not active properties

        foreach ($properties as $property){
            $not_active = $property->status == 0 ? ++$not_active: $not_active;
            $property->status = $property->status ==  1 ? 'Active' : 'Not active';
            $property->images->source = unserialize($property->images->source);
            $property->favorite = $property->isFavorited();
        }

        return view('user.user',compact(['properties','not_active']));
    }


    /**********************
    ** function edit user 
    ** return view (user's edit)
    ** no parameters
    ** 
    */
    public function edit(){
        $user = Auth::user();
        return view('user.edit',compact('user'));
    }

    /***********************
    ** function favorite properties to user 
    ** return view (user's fav property)
    ** no parameters
    ** 
    */
    public function favorite(){
        $user = Auth::user();
        $properties = $user->favorite(Property::class);

        foreach($properties as $property){
            $property->images->source = unserialize($property->images->source);
            $property->favorite = $property->isFavorited();
          
        }
    //   return $properties;
    return view('user.favorite', compact('properties'));
    }

    /***********************
    ** function update  user data 
    ** return 
    **  parameters $request and $id
    ** 
    */
    public function update(Request $request,$id){
        $res = User::findorfail($id);
        // if existed email equal inserted email 
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

        if($validator->passes()) {
            $res->update($request->all());
            return redirect()->route('user.index')->with('success_update','data is updated successfully');
        }
        return redirect()->back()->withErrors($validator)->withInput($request->all());
    }

    /***********************
    ** function change  user password 
    ** return view
    ** no parameters
    ** 
    */
    public function change_password(){
        $user = Auth::user();
        return view('user.change_password',compact('user'));
    }

    /***********************
    ** function change  user password
    ** return redirect with messages
    ** no parameters
    ** 
    */
    public function store_change_password(Request $request, $id){

        $res = User::findorfail($id);

        if (Hash::check($request->old_password, $res->password)){
            if($request->new_password == $request->confirm_new_password)
                $res->update(['password' => Hash::make($request->new_password)]);
            else
                return redirect()->back()->withErrors(['not_same'=>'The Password is not the same']);    // not same
        }else
            return redirect()->back()->withErrors(['pass_wrong'=>'The password is Wrong']);  // pass is wrong
        return redirect()->route('user.index')->with('success_update','data is updated successfully');    
    }
    
}