<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Product::all());
    }

    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
        ]);

        $product = new Product($request->all());
        $product->save();
        return response()->json($product, 201);
    }

    public function view(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    public function update(Request $request, Product $product): JsonResponse
    {
    }

    public function delete(Product $product): Response
    {
        $product->delete();
        return response()->noContent();
    }
}
