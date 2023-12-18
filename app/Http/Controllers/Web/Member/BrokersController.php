<?php

namespace App\Http\Controllers\Web\Member;

use App\Http\Controllers\Controller;
use App\Models\Brokers;
use Illuminate\Http\Request;

class BrokersController extends Controller
{
    public function index()
    {
        $brokers = Brokers::all();
        return view('member/brokers', compact('brokers'));
    }
}
