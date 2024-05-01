<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

use App\Models\ActivityRelation;

class ActivityRelationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $relations = QueryBuilder::for(ActivityRelation::class)
            ->with([
                'sourceActivity',
                'targetActivity',
                'condition',
            ])
            ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Get activities relations successfully',
            'data' => $relations,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Get activity relation form successfully',
            'form' => [
                'source_id' => '',
                'target_id' => '',
                'condition_id' => '',

            ],
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'source_id' => 'required|integer|exists:activities,id',
            'target_id' => 'required|integer|exists:activities,id',
            'condition_id' => 'integer|exists:conditions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $relation = new ActivityRelation();
        $relation->source_id = $request->source_id;
        $relation->target_id = $request->target_id;
        $relation->condition_id = $request->condition_id;
        $relation->save();

        return response()->json([
            'success' => true,
            'message' => 'Activity relation created successfully',
            'data' => $relation,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $relation = QueryBuilder::for(ActivityRelation::class)
            ->where('id', $id)
            ->with([
                'sourceActivity',
                'targetActivity',
                'condition',
            ])
            ->first();

        if (!$relation){
            return response()->json([
            'success' => true,
            'message' => 'Activity relation not found',
        ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get activity relation successfully',
            'data' => $relation,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $relation = ActivityRelation::where('id', $id)->first();

        if (!$relation){
            return response()->json([
            'success' => true,
            'message' => 'Activity relation not found',
        ], Response::HTTP_NOT_FOUND);
        }

         return response()->json([
            'success' => true,
            'message' => 'Get activity relation successfully',
            'form' => [
                'source_id' => $relation->source_id,
                'target_id' => $relation->target_id,
                'condition_id' => $relation->condition_id
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'source_id' => 'required|integer|exists:activities,id',
            'target_id' => 'required|integer|exists:activities,id',
            'condition_id' => 'integer|exists:conditions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $relation = ActivityRelation::find($id);

        if (!$relation) {
            return response()->json([
                'success' => false,
                'message' => 'Activity relation not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $relation->source_id = $request->source_id;
        $relation->target_id = $request->target_id;
        $relation->condition_id = $request->condition_id;
        $relation->save();

        return response()->json([
            'success' => true,
            'message' => 'Activity relation updated successfully',
            'data' => $relation,
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $relation = ActivityRelation::find($id);

        if (!$relation) {
            return response()->json([
                'success' => false,
                'message' => 'Activity relation not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $relation->delete();
        return response()->json([
            'success' => true,
            'message' => 'Activity relation deleted successfully.',
        ], Response::HTTP_OK);
    }
}
