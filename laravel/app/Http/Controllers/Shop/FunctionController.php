<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Members;
use App\Shops;
use Validator;

class FunctionController extends Controller
{

	private $shops_img_dir = 'webmgr/upload/shops/';

    public function __construct()
    {

    }

    public function create(Request $request,$member_id)
    {
        $validator = Validator::make($request->all(),
            [
                'nickname' => 'required|max:255',
                'taxid' => 'required|max:8',
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|max:20',
                'address' => 'required|max:255',
            ],
            [
                'nickname.required' => '商家名稱 - 必填',
                'nickname.max' => '商家名稱 - 字數過多',
                'taxid.required' => '統一編號 - 必填',
                'taxid.max' => '統一編號 - 字數過多',
                'name.required' => '出貨人姓名 - 必填',
                'name.max' => '出貨人姓名 - 字數過多',
                'email.required' => '電子郵件 - 必填',
                'email.email' => '電子郵件 - 格式錯誤',
                'phone.required' => '連絡電話 - 必填',
                'phone.max' => '連絡電話 - 字數過多',
                'address.required' => '出貨地址 - 必填',
                'address.max' => '出貨地址 - 字數過多',
            ]
        );
        if($validator->fails()){

            return back()->withErrors($validator)->withInput();
        }
        $shop_id = time();
        $new_tb_Shop = new Shops;
        $new_tb_Shop->id = $shop_id;
        $new_tb_Shop->members_id = $member_id;
        $new_tb_Shop->name = $request->nickname;
        $new_tb_Shop->premission = 0;
        $info_arr = [
            "name" => $request->name,
            "taxid" => $request->taxid,
            "email" => [$request->email],
            "phone" => [$request->phone],
            "address" => [$request->address]
        ];
        $new_tb_Shop->info = json_encode($info_arr);
        $imgName = $shop_id.'.jpg';
        \File::makeDirectory($this->shops_img_dir,0775,true,true);
        \Image::make($this->shops_img_dir.'default_shop.jpg')->save($this->shops_img_dir.$imgName);
        $new_tb_Shop->logo = $imgName;
        $new_tb_Shop->save();

        return redirect('/member/'.$member_id.'/edit');
    }

    public function update(Request $request,$member_id,$shop_id)
    {
        $upd_tb_Shops = Shops::find($shop_id);
        $change_count = array();
        $info_arr = json_decode($upd_tb_Shops->info);
        if(!empty($request->nickname) && $upd_tb_Shops->name != $request->nickname){
            $upd_tb_Shops->name = $request->nickname;
            $change_count['nickname'] = $upd_tb_Shops->name;
        }
        if(!empty($request->name) && $info_arr->name != $request->name){
            $info_arr->name = $request->name;
            $change_count['name'] = $info_arr->name;
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
        $file = $request->file('shopLogo');
        if($file){
            $extension = $file->getClientOriginalExtension();
            $imgName = $upd_tb_Shops->id.'.'.$extension;
            \File::makeDirectory($this->shops_img_dir,0775,true,true);
            \File::delete($this->shops_img_dir . $upd_tb_Shops->logo);
            \Image::make($file->getRealPath())->save($this->shops_img_dir.$imgName);
            $upd_tb_Shops->logo = $imgName;
            $change_count['logo'] = $imgName;
        }
        if($info_arr != json_decode($upd_tb_Shops->info)){
            $upd_tb_Shops->info = json_encode($info_arr);
        }
        if(count($change_count) > 0){
            $upd_tb_Shops->save();
        }
            
        return redirect('/member/'.$member_id.'/shop/'.$upd_tb_Shops->id.'/edit');
    }


}