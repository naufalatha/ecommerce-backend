<?php

namespace App\Http\Controllers\Services\ProductCategories;

use App\Http\Controllers\Controller;
use App\Models\ProductCategories;

class ProductCategoriesQueries extends Controller
{
    public function all($id, $limit, $name, $show_product)
    {
        if ($id) {
            $category = ProductCategories::with(['products'])->find($id);

            if ($category) {
                return response()->json([
                    'success' => true,
                    'message' => 'Detail Data Kategori',
                    'data'    => $category
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Kategori Tidak Ditemukan!',
                ], 404);
            }
        }

        $category = ProductCategories::query();

        if ($name) {
            $category->where('name', 'like', '%' . $name . '%');
        }

        if ($show_product) {
            $category->with('products');
        }

        return response()->json([
            'success' => true,
            'message' => 'List Data Kategori',
            'data'    => $category->paginate($limit)
        ], 200);
    }
}
