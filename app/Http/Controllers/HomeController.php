<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        $packages = Course::where('is_active', 1)->get();
        return view('beranda', compact('packages'));
    }
}
