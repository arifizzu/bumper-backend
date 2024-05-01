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
                'form',
                'participants',
            ])
            ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Get activity successfully',
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
                'status' => '',
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
            'name' => 'required|string|max:255',
            'process_id' => 'required|integer|exists:processes,id',
            'form_id' => 'nullable|integer|exists:forms,id',
            'status' => 'required|string|max:255',
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

        $activity = new Activity();
        $activity->name = $request->name;
        $activity->process_id = $request->process_id;
        $activity->form_id = $request->form_id;
        $activity->status = $request->status;
        $activity->width = $request->width;
        $activity->height = $request->height;
        $activity->x_coordinate = $request->x_coordinate;
        $activity->y_coordinate = $request->y_coordinate;
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
                'form',
                'participants',
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
                'status' => $activity->status,
                'width' => $activity->width,
                'height'=> $activity->height,
                'x_coordinate' => $activity->x_coordinate,
                'y_coordinate' => $activity->y_coordinate,
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
            'status' => 'required|string|max:255',
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
        $activity->status = $request->status;
        $activity->width = $request->width;
        $activity->height = $request->height;
        $activity->x_coordinate = $request->x_coordinate;
        $activity->y_coordinate = $request->y_coordinate;
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
