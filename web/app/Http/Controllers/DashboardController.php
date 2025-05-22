<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $farmers = Farmer::paginate(5);
        return view('dashboard', compact('farmers'));
    }
} 