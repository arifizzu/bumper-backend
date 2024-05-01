<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Participant;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $participant = QueryBuilder::for(Participant::class)
            ->with([
                'activity',
                'users',
                'roles'
            ])
            ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Get participant successfully',
            'data' => $participant,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Get participant form successfully',
            'form' => [
                'type' => '',
                'activity_id' => '',
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255',
            'activity_id' => 'required|integer|exists:activities,id',
            'users' => 'array',
            'users.*' => 'integer|exists:users,id',
            'roles' => 'array',
            'roles.*' => 'integer|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $participant = new Participant();
        $participant->type = $request->type;
        $participant->activity_id = $request->activity_id;
        $participant->save();

        if ($request->type == "user" && $request->users) {
            $participant->users()->attach($request->users);
        }

        if ($request->type == "role" && $request->roles) {
            $participant->roles()->attach($request->roles);
        }

        $participantData = QueryBuilder::for(Participant::class)
            ->with([
                'activity',
                'users',
                'roles'
            ])
            ->where('id', $participant->id)
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'Participant created successfully',
            'data' => $participantData,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $participant = QueryBuilder::for(Participant::class)
            ->where('id', $id)
            ->with([
                'activity',
                'users',
                'roles',
            ])
            ->first();

        if (!$participant){
            return response()->json([
            'success' => true,
            'message' => 'Participant not found',
        ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get participant successfully',
            'data' => $participant,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $participant = QueryBuilder::for(Participant::class)
            ->where('id', $id)
            ->with([
                'activity',
                'users',
                'roles',
            ])
            ->first();

        if (!$participant){
            return response()->json([
            'success' => true,
            'message' => 'Participant not found',
        ], Response::HTTP_NOT_FOUND);
        }

         return response()->json([
            'success' => true,
            'message' => 'Get participant successfully',
            'form' => [
                'type' => $participant->type,
                'activity_id' => $participant->activity_id,
                'users' => $participant->users,
                'roles' => $participant->roles,
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255',
            'activity_id' => 'required|integer|exists:activities,id',
            'users' => 'array',
            'users.*' => 'integer|exists:users,id',
            'roles' => 'array',
            'roles.*' => 'integer|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        // $participant = Participant::find($id);

         $participant = QueryBuilder::for(Participant::class)
            ->where('id', $id)
            ->with([
                'activity',
                'users',
                'roles',
            ])
            ->first();

        if (!$participant) {
            return response()->json([
                'success' => false,
                'message' => 'Participant not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $participant->type = $request->type;
        $participant->activity_id = $request->activity_id;
        $participant->save();

        $participant->users()->detach();
        $participant->roles()->detach();

        if ($request->type == "user" && $request->users) {
            $participant->users()->attach($request->users);
        }

        if ($request->type == "role" && $request->roles) {
            $participant->roles()->attach($request->roles);
        }

        $participantData = QueryBuilder::for(Participant::class)
            ->with([
                'activity',
                'users',
                'roles'
            ])
            ->where('id', $participant->id)
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'Participant updated successfully',
            'data' => $participantData,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $participant = QueryBuilder::for(Participant::class)
            ->where('id', $id)
            ->with([
                'activity',
                'users',
                'roles',
            ])
            ->first();

        if (!$participant) {
            return response()->json([
                'success' => false,
                'message' => 'Participant not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $participant->users()->detach();
        $participant->roles()->detach();
        $participant->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Participant deleted successfully.',
        ], Response::HTTP_OK);
    }
}
