<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\BannerImage;
use App\Models\Blog;
use Hash;
use Auth;
use Str;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $admins = Admin::where('admin_type','!=',2)->get();
        $defaultProfile = BannerImage::whereId('15')->first()->image;

        return view('admin.admin')->with([
            'admins' => $admins,
            'defaultProfile' => $defaultProfile
        ]);

    }

    public function create(){
        $logedInAdmin = Auth::guard('admin')->user();
        if($logedInAdmin->admin_type == 1){
            return view('admin.create_admin');
        }else return abort(404);


    }

    public function store(Request $request){
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:admins',
            'password' => 'required|min:4',
            'status' => 'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'email.required' => trans('admin_validation.Email is required'),
            'email.unique' => trans('admin_validation.Email already exist'),
            'password.required' => trans('admin_validation.Password is required'),
            'password.min' => trans('admin_validation.Password Must be 4 characters'),
        ];
        $this->validate($request, $rules,$customMessages);

        $admin = new Admin();
        $admin->name =$request->name;
        $admin->email =$request->email;
        $admin->status =$request->status;
        $admin->password =Hash::make($request->password);
        $admin->slug = Str::slug($request->name)."-".date('Ymdhis');
        $admin->save();

        $notification = trans('admin_validation.Create Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function update(Request $request, $id){

        $admin = Admin::find($id);
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:admins,email,'. $admin->id,
            'password' => 'required|min:4',
            'status' => 'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'email.required' => trans('admin_validation.Email is required'),
            'email.unique' => trans('admin_validation.Email already exist'),
            'password.required' => trans('admin_validation.Password is required'),
            'password.min' => trans('admin_validation.Password Must be 4 characters'),
        ];
        $this->validate($request, $rules,$customMessages);


        $admin->name =$request->name;
        $admin->email =$request->email;
        $admin->status =$request->status;
        $admin->password =Hash::make($request->status);
        $admin->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function show($id){
        $admin = Admin::find($id);
        return response()->json(['admin' => $admin], 200);
    }

    public function destroy($id){
        $admin = Admin::find($id);
        if($admin->admin_type == 1){
            $notification = trans('admin_validation.You can not delete super admin');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        $exist_blog = Blog::where('admin_id', $admin->id)->count();
        if($exist_blog > 0){
            $notification = trans('admin_validation.You can not delete this admin, Because there are one or more blog has been created by admin.');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        $old_image = $admin->image;
        $admin->delete();
        if($old_image){
            if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
        }
        $notification = trans('admin_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function changeStatus($id){
        $admin = Admin::find($id);
        if($admin->status == 1){
            $admin->status = 0;
            $admin->save();
            $message = trans('admin_validation.Inactive Successfully');
        }else{
            $admin->status = 1;
            $admin->save();
            $message = trans('admin_validation.Active Successfully');
        }
        return response()->json($message);
    }
}
