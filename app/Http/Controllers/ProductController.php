<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order;

class ProductController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.dashboard');
    }

    public function create()
    {
        $orders = Order::latest()->get();
        $products = Product::latest()->get();

        return view('admin.products.create', compact('orders', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'preparation_time' => 'nullable|integer|min:0',
            'description' => 'required|string|min:10',
            'image' => 'required|image|max:10240', // 10 MB
        ]);

        $image = $request->file('image');
        $destination = public_path('images/feature');

        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }

        $filename = uniqid() . '.' . $image->extension();

        if (!$image->move($destination, $filename)) {
            return back()->with('error', 'The image failed to upload.');
        }

        Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'discounted_price' => $validated['discounted_price'] ?? null,
            'category' => $validated['category'] ?? null,
            'preparation_time' => $validated['preparation_time'] ?? null,
            'description' => $validated['description'],
            'image_path' => 'images/feature/' . $filename,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'preparation_time' => 'nullable|integer|min:0',
            'description' => 'required|string|min:10',
            'image' => 'sometimes|image|max:10240', // 10 MB
        ]);

        $data = [
            'name' => $validated['name'],
            'price' => $validated['price'],
            'discounted_price' => $validated['discounted_price'] ?? $product->discounted_price,
            'category' => $validated['category'] ?? $product->category,
            'preparation_time' => $validated['preparation_time'] ?? $product->preparation_time,
            'description' => $validated['description'],
        ];

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($product->image_path && file_exists(public_path($product->image_path))) {
                unlink(public_path($product->image_path));
            }

            $image = $request->file('image');
            $filename = uniqid() . '.' . $image->extension();
            $image->move(public_path('images/feature'), $filename);

            $data['image_path'] = 'images/feature/' . $filename;
        }

        $product->update($data);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->image_path && file_exists(public_path($product->image_path))) {
            unlink(public_path($product->image_path));
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
    }
}
