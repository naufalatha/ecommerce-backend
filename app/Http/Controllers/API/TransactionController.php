<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Services\Transaction\TransactionCommands;
use App\Http\Controllers\Services\Transaction\TransactionQueries;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    protected $transactionQueries, $transactionCommands;

    public function __construct()
    {
        $this->transactionQueries = new TransactionQueries();
        $this->transactionCommands = new TransactionCommands();
    }

    public function all(Request $request)
    {
        try {
            $id             = $request->input('id');
            $limit          = $request->input('limit', 6);
            $status         = $request->input('status');

            return $this->transactionQueries->all($id, $status, $limit);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function checkout(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'items' => 'required|array',
                'items.*.id' => 'exists:products,id',
                'total_price' => 'required',
                'shipping_price' => 'required',
                'status' => 'required|in:PENDING,SUCCESS,CANCELLED,FAILED,SHIPPING,SHIPPED'
            ]);

            if ($validator->fails()) {
                $errors = collect();
                foreach ($validator->errors()->getMessages() as $key => $value) {
                    foreach ($value as $error) {
                        $errors->push($error);
                    }
                }

                return response()->json([
                    'success' => false,
                    'errors' => $errors
                ], 400);
            };

            return $this->transactionCommands->checkout($request);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
