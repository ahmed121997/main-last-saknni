<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Model\Property;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->except(['adminLogin','adminCheck']);
    }
    public function username(){
        return 'email';
    }


    public function dashboard(){
        $user_count = User::count();
        $user_active = User::where('last_seen','<', now()->addMinutes(2))->where('last_seen','>', now()->subMinute(2))->get()->count();
        $property_count = Property::count();
        $not_active = Property::where('status',0)->get()->count();
        $count_iamges = count(Storage::disk('public')->files('images'));
        // Data Chart
        $max_month = 6;
        $start = Carbon::now()->startOfMonth()->subMonth($max_month - 1);
        $end = Carbon::now()->startOfMonth()->subMonth($max_month - 2);
        $months = [];
        $users = [];
        $properties = [];

        for($i=0;$i<6;$i++){
            $m = $start->format('F');
            $user = User::whereBetween('created_at', [$start, $end])->get();
            $property = Property::whereBetween('created_at', [$start, $end])->get();
            $months[]= $m;
            $users[$m]=count($user);
            $properties[$m]=count($property);
            $start->addMonthsNoOverflow(1);
            $end->addMonthsNoOverflow(1);
        }
        return view('admin.dashboard',compact(['user_count','property_count','not_active','months','users','properties','user_active','count_iamges']));
    }


    /**
     * user profile
     */
    public function user(){
        $users = User::select()->paginate(ENV('PAGINATION_COUNT','20'));
        foreach ($users as $user){
            $user->status = $user->email_verified_at !=  '' ? 'Verified' : 'Not verified';
            if($user->last_seen < now()->addMinutes(2) and $user->last_seen >  now()->subMinute(2))
                $user->last_seen = 'online';
        }
        return view('admin.user',compact(['users']));
    }


    public function property(){
        $properties = Property::with(['des','typeProperty','view','finish','payment'])->paginate(ENV('PAGINATION_COUNT','20'));
        $not_active = 0;
        foreach ($properties as $property){
            $not_active = $property->status == 0 ? ++$not_active: $not_active;
            $property->status = $property->status ==  1 ? 'active' : 'not active';
            $property->images->source = unserialize($property->images->source);
        }
        return view('admin.property',compact(['properties','not_active']));
    }

    public function adminLogin(){
        return view('admin.login');
    }
    public function adminCheck(Request $request){
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/admin');
        }

        return back()->withInput($request->only('email', 'remember'))->withErrors([
            'password' => __('auth.password'),
            ]);

    }

    public function logout(Request $request)
    {

        Auth::logout();
        return redirect('/');
    }




    /**
     * profile admin
     *
     */

     public function profile(){
        return view('admin.profile.admin');
     }
     public function profile_edit(){
        $user = Auth::guard('admin')->user();
        return view('admin.profile.edit',compact('user'));
     }

     public function profile_update(Request $request,$id){
        $res = Admin::findorfail($id);
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
            return redirect()->route('admin.profile')->with('success_update','data is updated successfully');
        }
        return redirect()->back()->withErrors($validator)->withInput($request->all());
    }



    public function verify_user(Request $request){
        $res = User::find($request->id);
        if(!$res){
            return response('false',401);
        }
        $res->update(['email_verified_at' => now(),]);
        $res->save();
        return response('true',200);
    }


    public function verify_property(Request $request){
        $res = Property::find($request->id);
        if(!$res){
            return response('false',401);
        }
        $res->status = 1;
        $res->save();
        return response('true',200);
    }

}
