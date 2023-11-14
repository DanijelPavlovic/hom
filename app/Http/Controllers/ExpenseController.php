<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Auth;
use Exception;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return $this->successfullResponse([
            'expenses' => Expense::where('user_id', Auth::user()->id)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        if (!Auth::user()->hasEnoughAmount($request->input('amount'))) {
            return response()->json(['message' => 'Not enough money'], 400);
        }

        try {
            $expense = Expense::create($request->only(['amount', 'description', 'category_id', 'user_id']));

            Auth::user()->deduceAmount($request->input('amount'));

            return $this->successfullResponse(['expense' => $expense]);

        } catch (Exception $e) {
            return $this->failResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        $expense = Expense::where('id', $id)->first();

        if (!$expense) {
            return $this->notFoundResponse('Expense not found');
        }

        return $this->successfullResponse(['expense' => $expense]);
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::where('id', $id)->first();

        if (!$expense) {
            return $this->notFoundResponse('Expense not found');
        }

        try {
            $expense->update($request->only(['description', 'amount']));

            return $this->successfullResponse(['expense' => $expense]);
        } catch (Exception $e) {
            return $this->failResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $expense = Expense::where('id', $id)->first();

        Auth::user()->addAmount($expense->amount);

        $expense->delete();

        return $this->successfullResponse(['message' => 'Expense deleted']);
    }

    private function validateRequest(Request $request)
    {
        $rules = [
            'description' => 'required',
            'amount' => 'required',
            'category_id' => 'required',
            'user_id' => 'required',
        ];

        $this->validate($request, $rules);
    }
}
