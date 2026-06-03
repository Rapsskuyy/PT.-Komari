<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Order;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'paid')->sum('total_price');
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalCourses = Course::count();
        $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact('totalOrders', 'totalRevenue', 'pendingOrders', 'totalCourses', 'recentOrders'));
    }

    public function courses()
    {
        $courses = Course::all();
        return view('admin.courses.index', compact('courses'));
    }

    public function courseStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'is_active' => 'boolean',
        ]);

        Course::create($validated);
        return back()->with('success', 'Course created successfully.');
    }

    public function courseUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'is_active' => 'boolean',
        ]);

        $course = Course::findOrFail($id);
        $course->update($validated);
        return back()->with('success', 'Course updated successfully.');
    }

    public function courseDestroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return back()->with('success', 'Course deleted successfully.');
    }

    public function orders()
    {
        $orders = Order::with('user', 'orderItems.course')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }
}
