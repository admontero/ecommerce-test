<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\CreateProductAction;
use App\DTOs\ProductDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\StoreProductRequest;
use App\Http\Requests\Api\v1\UpdateProductRequest;
use App\Models\Product;
use App\Http\Resources\v1\ProductResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(Product::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request, CreateProductAction $createProductAction): ProductResource
    {
        $product = $createProductAction->handle(ProductDTO::fromStoreRequest($request));

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
