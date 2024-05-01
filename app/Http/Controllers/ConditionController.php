<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Condition;

class ConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $condition = QueryBuilder::for(Condition::class)
            ->with([
                'relation',
            ])
            ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Get condition successfully',
            'data' => $condition,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Get condition form successfully',
            'form' => [
                'label' => '',
                'condition_variable' => '',
                'condition_operator' => '',
                'condition_value' => '',

            ],
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:255',
            'condition_variable' => 'required|string|max:255',
            'condition_operator' => 'required|string|max:255',
            'condition_value' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $condition = new Condition();
        $condition->label = $request->label;
        $condition->condition_variable = $request->condition_variable;
        $condition->condition_operator = $request->condition_operator;
        $condition->condition_value = $request->condition_value;
        $condition->save();

        return response()->json([
            'success' => true,
            'message' => 'Condition created successfully',
            'data' => $condition,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $condition = QueryBuilder::for(Condition::class)
            ->where('id', $id)
            ->with([
                'relation',
            ])
            ->first();

        if (!$condition){
            return response()->json([
            'success' => true,
            'message' => 'Condition not found',
        ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get condition successfully',
            'data' => $condition,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $condition = Condition::where('id', $id)->first();

        if (!$condition){
            return response()->json([
            'success' => true,
            'message' => 'Condition not found',
        ], Response::HTTP_NOT_FOUND);
        }

         return response()->json([
            'success' => true,
            'message' => 'Get condition successfully',
            'form' => [
                'label' => $condition->label,
                'condition_variable' => $condition->condition_variable,
                'condition_operator' => $condition->condition_operator,
                'condition_value' => $condition->condition_value,
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:255',
            'condition_variable' => 'required|string|max:255',
            'condition_operator' => 'required|string|max:255',
            'condition_value' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $condition = Condition::find($id);

        if (!$condition) {
            return response()->json([
                'success' => false,
                'message' => 'Condition not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $condition->label = $request->label;
        $condition->condition_variable = $request->condition_variable;
        $condition->condition_operator = $request->condition_operator;
        $condition->condition_value = $request->condition_value;
        $condition->save();

        return response()->json([
            'success' => true,
            'message' => 'Condition updated successfully',
            'data' => $condition,
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $condition = Condition::find($id);

        if (!$condition) {
            return response()->json([
                'success' => false,
                'message' => 'Condition not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $condition->delete();
        return response()->json([
            'success' => true,
            'message' => 'Condition deleted successfully.',
        ], Response::HTTP_OK);
    }
}
