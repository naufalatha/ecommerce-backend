<?php

namespace App\Http\Controllers\Services\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductQueries extends Controller
{
    public function all($id, $name, $price_from, $price_to, $categories, $limit)
    {
        if ($id) {
            $product = Product::with(['category', 'galleries'])->find($id);

            if ($product) {
                return response()->json([
                    'success' => true,
                    'message' => 'Detail Data Produk',
                    'data'    => $product
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Produk Tidak Ditemukan!',
                ], 404);
            }
        }

        //getAll Data Product
        $product = Product::with(['category', 'galleries']);

        if ($name) {
            $product->where('name', 'like', '%' . $name . '%');
        }

        if ($price_from) {
            $product->where('price', '>=', $price_from);
        }

        if ($price_to) {
            $product->where('price', '<=', $price_to);
        }

        if ($categories) {
            $product->where('categories', $categories);
        }

        return response()->json([
            'success' => true,
            'message' => 'List Data Produk',
            'data'    => $product->paginate($limit)
        ], 200);
    }
}
