<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(): View
    {
        $products = Product::all(); // atau bisa menggunakan filter tertentu
        return view('home', compact('products'));
    }
}
