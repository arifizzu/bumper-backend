<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

use App\Models\FieldListValue;

class FieldListValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $fieldId)
    {
        $fieldListValue = QueryBuilder::for(FieldListValue::class)
            ->where('field_id', $fieldId)
            ->with([
                'field',
            ])->get();

        return response()->json([
            'success' => true,
            'message' => 'Get fields successfully',
            'data' => $fieldListValue,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return response()->json([
            'success' => true,
            'message' => 'Get form successfully',
            'form' => [
                'label' => '',
                'value' => '',
                'field_id' => '',
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'label' => 'required|string|max:255|unique:fields_lists_values',
        //     'value' => 'required|string|max:255|unique:fields_lists_values',
        //     'field_id' => 'required|integer|exists:fields,id',
        // ]);

        $validator = Validator::make($request->all(), [
            'label' => [
                'required',
                'string',
                'max:255',
                Rule::unique('fields_lists_values')->where(function ($query) use ($request) {
                    return $query->where('field_id', $request->input('field_id'));
                }),
            ],
            'value' => [
                'required',
                'string',
                'max:255',
                Rule::unique('fields_lists_values')->where(function ($query) use ($request) {
                    return $query->where('field_id', $request->input('field_id'));
                }),
            ],
            'field_id' => 'required|integer|exists:fields,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $fieldListValue = new FieldListValue();
        $fieldListValue->label = $request->label;
        $fieldListValue->value = $request->value;
        $fieldListValue->field_id = $request->field_id;
        $fieldListValue->save();

        return response()->json([
            'success' => true,
            'message' => 'Value created successfully',
            'data' => $fieldListValue,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fieldListValue = QueryBuilder::for(FieldListValue::class)
            ->where('id', $id)
            ->with([
                'field',
            ])->first();

        if (!$fieldListValue){
            return response()->json([
            'success' => true,
            'message' => 'Value not found',
        ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get value successfully',
            'data' => $fieldListValue,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fieldListValue = FieldListValue::where('id', $id)->first();

        if (!$fieldListValue){
            return response()->json([
            'success' => true,
            'message' => 'Value not found',
        ], Response::HTTP_NOT_FOUND);
        }

         return response()->json([
            'success' => true,
            'message' => 'Get form successfully',
            'form' => [
                'label' => $fieldListValue->label,
                'value' => $fieldListValue->value,
                'field_id' => $fieldListValue->field_id,
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $validator = Validator::make($request->all(), [
        //     'label' => [
        //         'required',
        //         'string',
        //         'max:255',
        //         Rule::unique('fields_lists_values')->ignore($request->id),
        //     ],
        //     'value' => [
        //         'required',
        //         'string',
        //         'max:255',
        //         Rule::unique('fields_lists_values')->ignore($request->id),
        //     ],
        //     'field_id' => 'required|integer|exists:fields,id',
        // ]);

        $validator = Validator::make($request->all(), [
            'label' => [
                'required',
                'string',
                'max:255',
                Rule::unique('fields_lists_values')->where(function ($query) use ($request) {
                    return $query->where('field_id', $request->input('field_id'));
                })->ignore($request->id),
            ],
            'value' => [
                'required',
                'string',
                'max:255',
                Rule::unique('fields_lists_values')->where(function ($query) use ($request) {
                    return $query->where('field_id', $request->input('field_id'));
                })->ignore($request->id),
            ],
            'field_id' => 'required|integer|exists:fields,id',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $fieldListValue = FieldListValue::find($id);

        if (!$fieldListValue) {
            return response()->json([
                'success' => false,
                'message' => 'Value not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $fieldListValue->label = $request->label;
        $fieldListValue->value = $request->value;
        $fieldListValue->field_id = $request->field_id;
        $fieldListValue->save();

        return response()->json([
            'success' => true,
            'message' => 'Value updated successfully',
            'data' => $fieldListValue,
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fieldListValue = FieldListValue::find($id);

        if (!$fieldListValue) {
            return response()->json([
                'success' => false,
                'message' => 'Value not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $fieldListValue->delete();
        return response()->json([
            'success' => true,
            'message' => 'Value deleted successfully.',
        ], Response::HTTP_OK);
    }
}
