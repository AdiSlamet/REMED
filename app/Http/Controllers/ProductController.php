<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $products = Product::orderBy('created_at', 'DESC')->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info('Store method executed');

        $request->validate([
            'title' => 'required|max:255|string',
            'price' => 'required|numeric',
            'product_code' => 'required|max:255|string',
            'description' => 'required|string',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048'
        ]);

        $filename = null;
        $path = 'uploads/products/';

        if ($request->has('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $filename);
        }

        Product::create([
            'title' => $request->title,
            'price' => $request->price,
            'product_code' => $request->product_code,
            'description' => $request->description,
            'image' => $filename ? $path . $filename : null,
        ]);

        Log::info('Product created successfully');

        return redirect()->route('products.create')->with('success', 'Product added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required|max:255|string',
            'price' => 'required|numeric',
            'product_code' => 'required|max:255|string',
            'description' => 'required|string',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048'
        ]);

        $product = Product::findOrFail($id);

        $input = $request->all();

        if ($request->has('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/products/', $filename);

            if (File::exists($product->image)) {
                File::delete($product->image);
            }

            $input['image'] = 'uploads/products/' . $filename;
        } else {
            unset($input['image']);
        }

        $product->update($input);

        return redirect()->back()->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        if (File::exists($product->image)) {
            File::delete($product->image);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully');
    }
}