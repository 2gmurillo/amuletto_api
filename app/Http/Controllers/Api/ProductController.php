<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ProductCollection
     */
    public function index():ProductCollection
    {
        $products = Product::applySorts(request('sort'))->get();
        return ProductCollection::make($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product): ProductResource
    {
        return ProductResource::make($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     */
    public function destroy(Product $product)
    {
        //
    }
}
