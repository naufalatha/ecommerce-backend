<?php

namespace App\Http\Controllers\Services\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionQueries extends Controller
{
    public function all($id, $status, $limit)
    {
        if ($id) {
            $transaction = Transaction::with(['items.product'])->find($id);

            if ($transaction) {
                return response()->json([
                    'success' => true,
                    'message' => 'Detail Data Transaksi',
                    'data'    => $transaction
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Transaksi Tidak Ditemukan!',
                ], 404);
            }
        }

        $transaction = Transaction::with(['items.product'])->where('users_id', Auth::user()->id);

        if ($status) {
            $transaction->where('status', $status);
        }

        return response()->json([
            'success' => true,
            'message' => 'List Data Transaksi',
            'data'    => $transaction->paginate($limit)
        ], 200);
    }
}
