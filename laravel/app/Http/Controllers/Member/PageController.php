<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Members;
use App\Shops;

class PageController extends Controller
{

    public function __construct()
    {

    }

    public function index($member_id)
    {
        $tb_Member = Members::find($member_id);
        $tb_Shop = Shops::where('members_id', $member_id)->get();
        return view('member.index',[
            'tb_Member' => $tb_Member,
            'tb_Shop' => $tb_Shop
        ]);
    }

    public function edit($member_id)
    {
    	$tb_Member = Members::find($member_id);
        $tb_Shop = Shops::where('members_id', $member_id)->get();
    	return view('member.edit',[
    		'tb_Member' => $tb_Member,
            'tb_Shop' => $tb_Shop
    	]);
    }

}