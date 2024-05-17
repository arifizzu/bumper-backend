<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Field;
use App\Models\FieldLocation;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $formId)
    {
        $fields = QueryBuilder::for(Field::class)
            ->where('form_id', $formId)
            ->with([
                'fieldType',
                'form',
                'listValues',
                'location',
            ])->get();

        return response()->json([
            'success' => true,
            'message' => 'Get fields successfully',
            'data' => $fields,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Get field form successfully',
            'form' => [
                'caption' => '',
                'form_id' => '',
                'type_id' => '',
                'is_required' => '',
                'table_name' => '',
                'column_name' => '',
                // 'width' => '',
                // 'height' => '',
                // 'x_coordinate' => '',
                // 'y_coordinate' => '',
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'caption' => 'required|string|max:255',
            'form_id' => 'required|integer|exists:forms,id',
            // 'form_id' => 'required|integer',
            'type_id' => 'required|integer|exists:fields_types,id',
            'is_required' => 'required|boolean',
            'table_name' => 'nullable|string|max:255',
            'column_name' => 'nullable|string|max:255',
            // 'width' => 'required|integer',
            // 'height' => 'required|integer',
            // 'x_coordinate' => 'required|integer',
            // 'y_coordinate' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $field = new Field();
        $field->caption = $request->caption;
        $field->form_id = $request->form_id;
        $field->type_id = $request->type_id;
        $field->is_required = $request->is_required;
        $field->table_name = $request->table_name;
        $field->column_name = $request->column_name;
        // $field->width = $request->width;
        // $field->height = $request->height;
        // $field->x_coordinate = $request->x_coordinate;
        // $field->y_coordinate = $request->y_coordinate;
        $field->save();

        $fieldLocation = new FieldLocation();
        $fieldLocation->field_id = $field->id;
        $fieldLocation->width = 4;
        $fieldLocation->height = 2;
        $fieldLocation->x_coordinate = 0;
        $fieldLocation->y_coordinate = 0;
        $fieldLocation->save();

        return response()->json([
            'success' => true,
            'message' => 'Field created successfully',
            'data' => $field,
            'latestFieldId' => $field->id,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $field = QueryBuilder::for(Field::class)
            ->where('id', $id)
            ->with([
                'fieldType',
                'form',
                'listValues',
                'location',
            ])->first();

        if (!$field){
            return response()->json([
            'success' => true,
            'message' => 'Field not found',
        ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get field successfully',
            'data' => $field,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $field = Field::where('id', $id)->first();

        if (!$field){
            return response()->json([
            'success' => true,
            'message' => 'Field not found',
        ], Response::HTTP_NOT_FOUND);
        }

         return response()->json([
            'success' => true,
            'message' => 'Get form successfully',
            'form' => [
                'caption' => $field->caption,
                'form_id' => $field->form_id,
                'type_id' => $field->type_id,
                'is_required' => $field->is_required,
                'table_name' => $field->table_name,
                'column_name' => $field->column_name,
                // 'width' => $field->width,
                // 'height' => $field->height,
                // 'x_coordinate' => $field->x_coordinate,
                // 'y_coordinate' => $field->y_coordinate,
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $validator = Validator::make($request->all(), [
            'caption' => 'required|string|max:255',
            // 'form_id' => 'required|integer|exists:forms,id',
            // 'type_id' => 'required|integer|exists:fields_types,id',
            'is_required' => 'required|boolean',
            'table_name' => 'nullable|string|max:255',
            'column_name' => 'nullable|string|max:255',
            // 'width' => 'required|integer',
            // 'height' => 'required|integer',
            // 'x_coordinate' => 'required|integer',
            // 'y_coordinate' => 'required|integer',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $field = Field::find($id);

        if (!$field) {
            return response()->json([
                'success' => false,
                'message' => 'Field not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $field->caption = $request->caption;
        // $field->form_id = $request->form_id;
        // $field->type_id = $request->type_id;
        $field->is_required = $request->is_required;
        $field->table_name = $request->table_name;
        $field->column_name = $request->column_name;
        // $field->width = $request->width;
        // $field->height = $request->height;
        // $field->x_coordinate = $request->x_coordinate;
        // $field->y_coordinate = $request->y_coordinate;
        $field->save();

        return response()->json([
            'success' => true,
            'message' => 'Field updated successfully',
            'data' => $field,
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $field = Field::find($id);

        if (!$field) {
            return response()->json([
                'success' => false,
                'message' => 'Field not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $field->delete();
        return response()->json([
            'success' => true,
            'message' => 'Field deleted successfully.',
        ], Response::HTTP_OK);
    }
}
