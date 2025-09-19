<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\ProductResource;
use App\Models\Product;

use Validator;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $products = Product::all();
        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product = Product::create($input);

        return $this->sendResponse(new ProductResource($product), 'Product created successfully.');
    }

    /*
    *Display the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function show($id): JsonResponse
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|between:0,9999.99',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product->name = $input['name'];
        $product->description = $input['description'];
        $product->price = $input['price'];
        $product->save();

        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
