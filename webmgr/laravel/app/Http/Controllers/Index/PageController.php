<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
    	return view('index');
    }

    public function create()
    {
    	return view('users.create');
    }

    public function edit($user_id)
    {

        return view('users.edit');
    }

}