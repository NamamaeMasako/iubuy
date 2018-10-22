<?php

namespace App\Http\Controllers\PhotoGallery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Albums;
use App\Photos;

class PhotosController extends Controller
{
	private $pagerow = 20;
    private $img_dir = 'upload/photogallery/photos/';
    private $img_w = 380;
    private $img_h = 380;
    private $thumb_dir = 'upload/photogallery/photos/thumb/';
    private $thumb_tag = 's_';
    private $thumb_w = 45;
    private $thumb_h = 45;

	//--------------------------------------------------------------------

    public function __construct()
    {

    }

    public function index($albums_id){

    	$tb_Albums = Albums::find($albums_id);
        if(\Request::input('page')){
            $page = \Request::input('page');
        }else{
            $page = 1;
        }
    	return view('photogallery.photos.index',[
    		'albums_id' => $albums_id,
            'albums_Title_tw'  => $tb_Albums->Title_tw,
     		'tb_Photos' => $tb_Albums->Photos()->paginate($this->pagerow),
            'page' => $page,
    	]);
    }

    public function store(Request $request, $albums_id) {
    	//dd($request->file('imgName'));

        //檔案上傳
        $ary_file = $request->file('imgName');
        foreach($ary_file as $idx => $file) {
            $extension = $file->getClientOriginalExtension();
            $imgName = strval(time()) . str_random(5) . '.' . $extension;
            $thumbName = $this->thumb_tag . $imgName;

            \File::makeDirectory($this->img_dir,0775,true,true);
            \File::makeDirectory($this->thumb_dir,0775,true,true);

            // \Image::make($file->getRealPath())->resize($this->img_w, $this->img_h)->save($this->img_dir.$imgName);
            \Image::make($file->getRealPath())->resize($this->thumb_w, $this->thumb_h)->save($this->thumb_dir.$thumbName);
            $file->move($this->img_dir, $imgName);

            $new_tb_Photos = new Photos;
            $new_tb_Photos->albums_id = $albums_id;
            $new_tb_Photos->imgName = $imgName;
            $new_tb_Photos->thumbName = $thumbName;
        	$new_tb_Photos->save();
        }

        return redirect("/photogallery/$albums_id");
    }

    public function destroy($albums_id, $photos_id) {

        $tb_Photos = Photos::find($photos_id);
        \File::delete($this->img_dir . $tb_Photos->imgName);
        \File::delete($this->thumb_dir . $tb_Photos->thumbName);

        Photos::destroy($photos_id);

        return redirect("/photogallery/$albums_id");
    }

    public function edit($albums_id, $photos_id) {
        $tb_Albums = Albums::find($albums_id);
        $tb_Photos = Photos::find($photos_id);
        return view('photogallery.photos.edit', [
            'albums_id' => $albums_id,
            'albums_Title_tw'  => $tb_Albums->Title_tw,
            'tb_Photos' => $tb_Photos
        ]); 
    }

    public function update(Request $request, $albums_id, $photos_id) {

        $this->validate($request,
            $rules = [
                'Title_tw'  => 'required|max:30',
                'Title_cn'  => 'required|max:30',
                'Title_en'  => 'required|max:100',
            ],
            $messages = [
                'Title_tw.required' => '繁體標題為必填欄位',
                'Title_tw.max'      => '繁體標題需小於30個字',
                'Title_cn.required' => '簡體標題為必填欄位',
                'Title_cn.max'      => '簡體標題需小於30個字',
                'Title_en.required' => '英文標題為必填欄位',
                'Title_en.max'      => '英文標題需小於100個字',
            ]
        );


        $upd_tb_Photos = Photos::find($photos_id);

        $imgName = '';
        $thumbName = '';
        $file = $request->file('imgName');
        if ($file) {
            \File::delete($this->img_dir . $upd_tb_Photos->imgName);
            \File::delete($this->thumb_dir . $upd_tb_Photos->thumbName);

            $extension = $file->getClientOriginalExtension();
            $imgName = strval(time()) . str_random(5) . '.' . $extension;
            $thumbName = $this->thumb_tag . $imgName;

            \File::makeDirectory($this->img_dir,0775,true,true);
            \File::makeDirectory($this->thumb_dir,0775,true,true);

            \Image::make($file->getRealPath())->resize($this->img_w, $this->img_h)->save($this->img_dir.$imgName);
            \Image::make($file->getRealPath())->resize($this->thumb_w, $this->thumb_h)->save($this->thumb_dir.$thumbName);
            // $file->move($this->img_dir, $imgName);
        }

        $upd_tb_Photos->Title_tw = $request->Title_tw;
        $upd_tb_Photos->Title_cn = $request->Title_cn;
        $upd_tb_Photos->Title_en = $request->Title_en;
        if ($file) {
            $upd_tb_Photos->imgName = $imgName;
            $upd_tb_Photos->thumbName = $thumbName;
        }
        $upd_tb_Photos->updated_at = date('Y-m-d H:i:s');
        $upd_tb_Photos->save();

        return redirect("/photogallery/$albums_id");
    }

}