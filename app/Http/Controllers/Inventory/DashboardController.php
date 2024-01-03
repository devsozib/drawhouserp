<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Users;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $users = Users::orderBy('id','ASC')->get();
        return view('inventory.dashboard', compact('users'));
    }
}
