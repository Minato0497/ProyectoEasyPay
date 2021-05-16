<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransferBasicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
