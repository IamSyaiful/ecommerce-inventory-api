<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json([
            'status' => 'success',
            'data' => ProductResource::collection($products)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        $product->load('category');

        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($product),
            'message' => 'Produk berhasil dibuat'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($product)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Produk tidak ditemukan'], 404);
        }

        $product->update($request->validated());
        $product->load('category');

        return response()->json([
            'status' => 'success',
            'data' => new ProductResource($product),
            'message' => 'Produk berhasil diperbarui'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Produk tidak ditemukan'], 404);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil dihapus'
        ], 200);
    }

    public function search(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $products = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => ProductResource::collection($products)
        ], 200);
    }

    public function updateStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity_sold' => 'required|integer|min:1'
        ]);

        $product = Product::find($request->product_id);

        if ($product->stock_quantity < $request->quantity_sold) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jumlah barang yang terjual melebihi stok yang tersedia. Stok saat ini: ' . $product->stock_quantity
            ], 400);
        }

        $product->decrement('stock_quantity', $request->quantity_sold);

        $product->load('category');

        return response()->json([
            'status' => 'success',
            'message' => 'Stok produk berhasil diperbarui',
            'data' => new ProductResource($product)
        ], 200);
    }

    public function totalValue()
    {
        $totalValue = Product::selectRaw('SUM(price * stock_quantity) as total_value')->value('total_value');

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_inventory_value' => (float) $totalValue,
                'currency' => 'IDR'
            ]
        ], 200);
    }
}
