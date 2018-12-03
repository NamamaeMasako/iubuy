<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Members;
use App\MemberProfiles;
use App\Shops;

class PageController extends Controller
{

    public function __construct()
    {

    }

    public function index($member_account)
    {
        $tb_Member = Members::where('account',$member_account)->first();
        $tb_Shop = Shops::where('members_account', $member_account)->get();
        return view('member.index',[
            'tb_Member' => $tb_Member,
            'tb_Shop' => $tb_Shop
        ]);
    }

    public function edit($member_account)
    {
    	$tb_Member = Members::where('account',$member_account)->first();
        $tb_MemberProfile = MemberProfiles::where('members_account', $member_account)->first();
        $tb_Shop = Shops::where('members_account', $member_account)->get();
    	return view('member.edit',[
    		'tb_Member' => $tb_Member,
            'tb_MemberProfile' => $tb_MemberProfile,
            'tb_Shop' => $tb_Shop
    	]);
    }

}