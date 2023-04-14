<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Services\ProductCategories\ProductCategoriesQueries;
use Exception;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    protected $productCategoryQueries;

    public function __construct()
    {
        $this->productCategoryQueries = new ProductCategoriesQueries();
    }

    public function all(Request $request)
    {
        try {
            $id             = $request->input('id');
            $limit          = $request->input('limit') ?? 6;
            $name           = $request->input('name');
            $show_product   = $request->input('show_product');

            return $this->productCategoryQueries->all($id, $limit, $name, $show_product);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
