<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id'=>'required|exists:users,id',
            'type'=>'required|in:income,expense',
            'amount'=>'required|numeric|min:0.01'
        ]);

        return response()->json(
            Transaction::create($request->only('user_id','type','amount','description')),
            201
        );
    }

    public function getByUser($id)
    {
        return response()->json(
            User::findOrFail($id)->transactions
        );
    }

    public function getBalance($id)
    {
        $income = Transaction::where('user_id',$id)
                    ->where('type','income')
                    ->sum('amount');

        $expense = Transaction::where('user_id',$id)
                    ->where('type','expense')
                    ->sum('amount');

        return response()->json([
            'balance'=>$income-$expense
        ]);
    }
}
