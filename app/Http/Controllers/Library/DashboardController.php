<?php

namespace App\Http\Controllers\Library;

use Sentinel;
use Carbon\Carbon;
use App\Models\Users;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $users = Users::orderBy('id','ASC')->get();
        return view('library.dashboard', compact('users'));
    }
}
