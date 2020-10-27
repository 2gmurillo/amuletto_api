<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ResourceCollection;
use App\Http\Resources\ResourceObject;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $products = Product::applyFilters()->applySorts()->jsonPaginate();
        return ResourceCollection::make($products);
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
     * @return ResourceObject
     */
    public function show(Product $product): ResourceObject
    {
        return ResourceObject::make($product);
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
