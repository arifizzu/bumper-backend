<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Form;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $forms = QueryBuilder::for(Form::class)
            ->with([
                'fields',
            ])->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Get forms successfully',
            'data' => $forms,
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
                'name' => '',
                'short_name' => '',
                'table_name' => '',
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:255|unique:forms',
            // 'short_name' => 'required|string|max:255',
            'table_name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $form = new Form();
        $form->name = $request->name;
        $form->short_name = $request->short_name;
        $form->table_name = $request->table_name;
        $form->save();

        return response()->json([
            'success' => true,
            'message' => 'Form created successfully',
            'data' => $form,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $form = QueryBuilder::for(Form::class)
            ->where('id', $id)
            ->with([
                'fields',
            ])->first();

        if (!$form){
            return response()->json([
            'success' => true,
            'message' => 'Form not found',
        ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get form successfully',
            'data' => $form,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $form = Form::where('id', $id)->first();

        if (!$form){
            return response()->json([
            'success' => true,
            'message' => 'Form not found',
        ], Response::HTTP_NOT_FOUND);
        }

         return response()->json([
            'success' => true,
            'message' => 'Get form successfully',
            'form' => [
                'name' => $form->name,
                'short_name' => $form->short_name,
                'table_name' => $form->table_name,
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'short_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('forms')->ignore($request->id),
            ],
            'table_name' => 'nullable|string|min:8',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $form = Form::find($id);

        if (!$form) {
            return response()->json([
                'success' => false,
                'message' => 'Form not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $form->name = $request->name;
        $form->short_name = $request->short_name;
        $form->table_name = $request->table_name;
        $form->save();

        return response()->json([
            'success' => true,
            'message' => 'Form updated successfully',
            'data' => $form,
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $form = Form::find($id);

        if (!$form) {
            return response()->json([
                'success' => false,
                'message' => 'Form not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $form->delete();
        return response()->json([
            'success' => true,
            'message' => 'Form deleted successfully.',
        ], Response::HTTP_OK);
    }
}
