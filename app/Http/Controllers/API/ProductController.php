<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Services\Product\ProductQueries;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productQueries;

    public function __construct()
    {
        $this->productQueries = new ProductQueries();
    }

    public function all(Request $request)
    {
        try {
            $id             = $request->input('id');
            $limit          = $request->input('limit', 6);
            $name           = $request->input('name');
            $categories     = $request->input('categories');

            $price_from     = $request->input('price_from');
            $price_to       = $request->input('price_to');

            return $this->productQueries->all($id, $name, $price_from, $price_to, $categories, $limit);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
