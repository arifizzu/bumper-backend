<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Models\FieldLocation;
use App\Models\Field;

class FieldLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fieldLocation = QueryBuilder::for(FieldLocation::class)
            ->with([
                'field',
            ])
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Get fields locations successfully',
            'data' => $fieldLocation,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Get field location form successfully',
            'form' => [
                'field_id' => '',
                'width' => '',
                'height' => '',
                'x_coordinate' => '',
                'y_coordinate' => '',
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'field_id' => 'required|integer|exists:fields,id',
            'form_id' => 'required|integer|exists:forms,id',
            'caption' => 'required|string|max:255',
            'width' => 'required|integer',
            'height' => 'required|integer',
            'x_coordinate' => 'required|integer',
            'y_coordinate' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $field = QueryBuilder::for(Field::class)
            ->where('form_id', $request->form_id)
            ->where('caption', $request->caption)
            ->first();

        $fieldLocation = new FieldLocation();
        $fieldLocation->field_id = $field->id;
        $fieldLocation->width = $request->width;
        $fieldLocation->height = $request->height;
        $fieldLocation->x_coordinate = $request->x_coordinate;
        $fieldLocation->y_coordinate = $request->y_coordinate;
        $fieldLocation->save();

        $fieldLocationData = QueryBuilder::for(FieldLocation::class)
            ->where('id', $fieldLocation->id)
            ->with([
                'field',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'Field Location created successfully',
            'data' => $fieldLocationData,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $field = QueryBuilder::for(Field::class)
            ->where('form_id', $request->form_id)
            ->where('caption', $request->caption)
            ->first();

        $fieldLocation = QueryBuilder::for(FieldLocation::class)
            ->where('field_id', $field->id)
            ->with([
                'field',
            ])->first();

        if (!$fieldLocation){
            return response()->json([
            'success' => true,
            'message' => 'Field Location not found',
        ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get field location successfully',
            'data' => $fieldLocation,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
         $validator = Validator::make($request->all(), [
            // 'field_id' => 'required|integer|exists:fields,id',
            'form_id' => 'required|integer|exists:forms,id',
            'caption' => 'required|string|max:255',
        ]);

         if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $field = QueryBuilder::for(Field::class)
            ->where('form_id', $request->form_id)
            ->where('caption', $request->caption)
            ->first();
        
        $fieldLocation = QueryBuilder::for(FieldLocation::class)
            ->where('field_id', $field->id)
            ->with([
                'field',
            ])->first();

        if (!$fieldLocation){
            return response()->json([
            'success' => true,
            'message' => 'Field Location not found',
        ], Response::HTTP_NOT_FOUND);
        }

         return response()->json([
            'success' => true,
            'message' => 'Get field location form successfully',
            'form' => [
                'field_id' => $fieldLocation->field_id,
                'width' => $fieldLocation->width,
                'height' => $fieldLocation->height,
                'x_coordinate' => $fieldLocation->x_coordinate,
                'y_coordinate' => $fieldLocation->y_coordinate,
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'field_id' => 'required|integer|exists:fields,id',
            'form_id' => 'required|integer|exists:forms,id',
            'caption' => 'required|string|max:255',
            'width' => 'required|integer',
            'height' => 'required|integer',
            'x_coordinate' => 'required|integer',
            'y_coordinate' => 'required|integer',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $field = QueryBuilder::for(Field::class)
            ->where('form_id', $request->form_id)
            ->where('caption', $request->caption)
            ->first();

        $fieldLocation = QueryBuilder::for(FieldLocation::class)
            ->where('field_id', $field->id)
            ->first();

        if (!$fieldLocation) {
            return response()->json([
                'success' => false,
                'message' => 'Field Location not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        // $fieldLocation->field_id = $request->field.id;
        $fieldLocation->width = $request->width;
        $fieldLocation->height = $request->height;
        $fieldLocation->x_coordinate = $request->x_coordinate;
        $fieldLocation->y_coordinate = $request->y_coordinate;
        $fieldLocation->save();

        $fieldLocationData = QueryBuilder::for(FieldLocation::class)
            ->where('id', $fieldLocation->id)
            ->with([
                'field',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'Field Location updated successfully',
            'data' => $fieldLocationData,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $field = QueryBuilder::for(Field::class)
            ->where('form_id', $request->form_id)
            ->where('caption', $request->caption)
            ->first();

        $fieldLocation = QueryBuilder::for(FieldLocation::class)
            ->where('field_id', $field->id)
            ->first();

        if (!$fieldLocation) {
            return response()->json([
                'success' => false,
                'message' => 'Field Location not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $fieldLocation->delete();
        return response()->json([
            'success' => true,
            'message' => 'Field Location deleted successfully.',
        ], Response::HTTP_OK);
    }

}
