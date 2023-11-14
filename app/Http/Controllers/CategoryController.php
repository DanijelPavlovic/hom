<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return $this->successfullResponse([
            'expenses' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        try {
            $category = Category::create($request->only(['name', 'description']));

            return $this->successfullResponse([
                'category' => $category,
            ]);

        } catch (Exception $e) {
            return $this->failResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        $category = Category::where('id', $id)->first();

        if (!$category) {
            return $this->notFoundResponse('Category not found');
        }

        return $this->successfullResponse([
            'category' => $category,
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::where('id', $id)->first();

        if (!$category) {
            return $this->notFoundResponse('Category not found');
        }

        try {
            $category->update($request->only(['name', 'description']));

            return $this->successfullResponse([
                'category' => $category,
            ]);
        } catch (Exception $e) {
            return $this->failResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        Category::where('id', $id)->delete();

        return $this->successfullResponse(['message' => 'Category deleted']);
    }

    private function validateRequest(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];

        $this->validate($request, $rules);
    }
}
