<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        return view('katalog', compact('products'));
    }
    public function show(Request $id) {
            $product = Product::findOrFail($id);
            return view('detail', compact('product'));
    }
}
