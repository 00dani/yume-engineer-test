<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Product::all());
    }

    public function create(Request $request): JsonResponse
    {
    }

    public function view(Product $product): JsonResponse
    {
    }

    public function update(Request $request, Product $product): JsonResponse
    {
    }

    public function delete(Product $product): JsonResponse
    {
    }
}
