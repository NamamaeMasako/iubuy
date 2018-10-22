<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Members;
use Validator;

class FunctionController extends Controller
{

	private $members_img_dir = 'webmgr/upload/members/';

    public function __construct()
    {

    }

    public function update(Request $request,$member_id)
    {
        $upd_tb_Members = Members::find($member_id);
        $change_count = array();
        $info_arr = json_decode($upd_tb_Members->info);
        if(!empty($request->nickname) && $upd_tb_Members->name != $request->nickname){
            $upd_tb_Members->name = $request->nickname;
            $change_count['nickname'] = $upd_tb_Members->name;
        }
        if(!empty($request->name) && $info_arr->name != $request->name){
            $info_arr->name = $request->name;
            $change_count['name'] = $info_arr->name;
        }
        if(!empty($request->gender) && $info_arr->gender != $request->gender){
            $info_arr->gender = $request->gender;
            $change_count['gender'] = $info_arr->gender;
        }
        if(!empty($request->email) && $info_arr->email != array_filter($request->email)){
            $info_arr->email = array_filter($request->email);
            $change_count['mail'] = $info_arr->email;
        }
        if(!empty($request->phone)){
            if(!empty(array_filter($request->phone))){
                if(empty($info_arr->phone) || $info_arr->phone != array_filter($request->phone)){
                    $array_filter = array();
                    foreach (array_filter($request->phone) as $value) {
                        array_push($array_filter, $value);
                    }
                    $info_arr->phone = $array_filter;
                    $change_count['phone'] = $info_arr->phone;
                }
            }else{
                unset($info_arr->phone);
                $change_count['phone'] = " ";
            }
        }
        if(!empty($request->address)){
            if(!empty(array_filter($request->address))){
                if(empty($info_arr->address) || $info_arr->address != array_filter($request->address)){
                    $array_filter = array();
                    foreach (array_filter($request->address) as $value) {
                        array_push($array_filter, $value);
                    }
                    $info_arr->address = $array_filter;
                    $change_count['address'] = $info_arr->address;
                }
            }else{
                unset($info_arr->address);
                $change_count['address'] = " ";
            }
        }
        $file = $request->file('avator');
        if($file){
            $extension = $file->getClientOriginalExtension();
            $imgName = $upd_tb_Members->id.'.'.$extension;
            \File::delete($this->members_img_dir . $upd_tb_Members->avator);
            \File::makeDirectory($this->members_img_dir,0775,true,true);
            \Image::make($file->getRealPath())->save($this->members_img_dir.$imgName);
            $upd_tb_Members->avator = $imgName;
            $change_count['avator'] = $request->avator;
        }
        if($info_arr != json_decode($upd_tb_Members->info)){
            $upd_tb_Members->info = json_encode($info_arr);
        }
        if(count($change_count) > 0){
            $upd_tb_Members->save();
        }
            
        return redirect('/member/'.$upd_tb_Members->id.'/edit');
    }


}