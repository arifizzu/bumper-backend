<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Activity;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $activities = QueryBuilder::for(Activity::class)
            ->with([
                'process',
                'relations',
            ])
            ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Get process successfully',
            'data' => $activities,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Get activity form successfully',
            'form' => [
                'name' => '',
                'process_id' => '',
                'form_id' => '',
                'reference_id' => '',
                'status' => '',
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
            'process_id' => 'required|integer|exists:processes,id',
            'form_id' => 'nullable|integer|exists:forms,id',
            'reference_id' => 'nullable|integer|exists:activities,id',
            'status' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $activity = new Activity();
        $activity->name = $request->name;
        $activity->process_id = $request->process_id;
        $activity->form_id = $request->form_id;
        $activity->reference_id = $request->reference_id;
        $activity->status = $request->status;
        $activity->save();

        return response()->json([
            'success' => true,
            'message' => 'Activity created successfully',
            'data' => $activity,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $activity = QueryBuilder::for(Activity::class)
            ->where('id', $id)
            ->with([
                 'process',
                'relations',
            ])
            ->first();

        if (!$activity){
            return response()->json([
            'success' => true,
            'message' => 'Activity not found',
        ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get activity successfully',
            'data' => $activity,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $activity = Activity::where('id', $id)->first();

        if (!$activity){
            return response()->json([
            'success' => true,
            'message' => 'Activity not found',
        ], Response::HTTP_NOT_FOUND);
        }

         return response()->json([
            'success' => true,
            'message' => 'Get activity successfully',
            'form' => [
                'name' => $activity->name,
                'process_id' => $activity->process_id,
                'form_id' => $activity->form_id,
                'reference_id' => $activity->reference_id,
                'status' => $activity->status,
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
            'process_id' => 'required|integer|exists:processes,id',
            'form_id' => 'nullable|integer|exists:forms,id',
            'reference_id' => 'nullable|integer|exists:activities,id',
            'status' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $activity = Activity::find($id);

        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'Activity not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $activity->name = $request->name;
        $activity->process_id = $request->process_id;
        $activity->form_id = $request->form_id;
        $activity->reference_id = $request->reference_id;
        $activity->status = $request->status;
        $activity->save();

        return response()->json([
            'success' => true,
            'message' => 'Activity updated successfully',
            'data' => $activity,
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $activity = Activity::find($id);

        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'Activity not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $activity->delete();
        return response()->json([
            'success' => true,
            'message' => 'Activity deleted successfully.',
        ], Response::HTTP_OK);
    }
}
