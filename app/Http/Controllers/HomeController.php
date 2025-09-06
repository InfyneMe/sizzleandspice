<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuModel;
use App\Models\OrderedItemsModel;
use App\Models\OrdersModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index(){
        return view('home.dashboard');
    }

}
