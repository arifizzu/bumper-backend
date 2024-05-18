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

use App\Models\ActivityLocation;
use App\Models\Activity;

class ActivityLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $activityLocation = QueryBuilder::for(ActivityLocation::class)
            ->with([
                'activity',
            ])
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Get activities locations successfully',
            'data' => $activityLocation,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Get activity location form successfully',
            'form' => [
                'activity_id' => '',
                'w' => '',
                'h' => '',
                'x' => '',
                'y' => '',
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'process_id' => 'required|integer|exists:processes,id',
            'name' => 'required|string|max:255',
            'w' => 'required|integer',
            'h' => 'required|integer',
            'x' => 'required|integer',
            'y' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $activity = QueryBuilder::for(Activity::class)
            ->where('process_id', $request->process_id)
            ->where('name', $request->name)
            ->first();

        $activityLocation = new ActivityLocation();
        $activityLocation->activity_id = $activity->id;
        $activityLocation->w = $request->w;
        $activityLocation->h = $request->h;
        $activityLocation->x = $request->x;
        $activityLocation->y = $request->y;
        $activityLocation->save();

        $activityLocationData = QueryBuilder::for(ActivityLocation::class)
            ->where('id', $activityLocation->id)
            ->with([
                'activity',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'Activity Location created successfully',
            'data' => $activityLocationData,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $activity = QueryBuilder::for(Activity::class)
            ->where('process_id', $request->process_id)
            ->where('name', $request->name)
            ->first();

        $activityLocation = QueryBuilder::for(ActivityLocation::class)
            ->where('activity_id', $activity->id)
            ->with([
                'activity',
            ])->first();

        if (!$activityLocation){
            return response()->json([
            'success' => true,
            'data' => $activity,
            'message' => 'Activity Location not found',
        ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get activity location successfully',
            'data' => $activityLocation,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'process_id' => 'required|integer|exists:processes,id',
            'name' => 'required|string|max:255',
        ]);

         if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $activity = QueryBuilder::for(Activity::class)
            ->where('process_id', $request->process_id)
            ->where('name', $request->name)
            ->first();
        
        $activityLocation = QueryBuilder::for(ActivityLocation::class)
            ->where('activity_id', $activity->id)
            ->with([
                'activity',
            ])->first();

        if (!$activityLocation){
            return response()->json([
            'success' => true,
            'message' => 'Activity Location not found',
        ], Response::HTTP_NOT_FOUND);
        }

         return response()->json([
            'success' => true,
            'message' => 'Get activity location form successfully',
            'form' => [
                'activity_id' => $activityLocation->activity_id,
                'w' => $activityLocation->w,
                'h' => $activityLocation->h,
                'x' => $activityLocation->x,
                'y' => $activityLocation->y,
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'process_id' => 'required|integer|exists:processes,id',
            'name' => 'required|string|max:255',
            'w' => 'required|integer',
            'h' => 'required|integer',
            'x' => 'required|integer',
            'y' => 'required|integer',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $activity = QueryBuilder::for(Activity::class)
            ->where('process_id', $request->process_id)
            ->where('name', $request->name)
            ->first();

        $activityLocation = QueryBuilder::for(ActivityLocation::class)
            ->where('activity_id', $activity->id)
            ->first();


        if (!$activityLocation) {
            return response()->json([
                'success' => false,
                'message' => 'Activity Location not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $activityLocation->w = $request->w;
        $activityLocation->h = $request->h;
        $activityLocation->x = $request->x;
        $activityLocation->y = $request->y;
        $activityLocation->save();

        $activityLocationData = QueryBuilder::for(ActivityLocation::class)
            ->where('id', $activityLocation->id)
            ->with([
                'activity',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'Activity Location updated successfully',
            'data' => $activityLocationData,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $activity = QueryBuilder::for(Activity::class)
            ->where('process_id', $request->process_id)
            ->where('name', $request->name)
            ->first();

        $activityLocation = QueryBuilder::for(ActivityLocation::class)
            ->where('activity_id', $activity->id)
            ->first();

        if (!$activityLocation) {
            return response()->json([
                'success' => false,
                'message' => 'Activity Location not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $activityLocation->delete();
        return response()->json([
            'success' => true,
            'message' => 'Activity Location deleted successfully.',
        ], Response::HTTP_OK);
    }

}
