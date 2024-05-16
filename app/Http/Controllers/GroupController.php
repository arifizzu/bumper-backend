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

use App\Http\Controllers\UserLogController;
use App\Models\Group;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $groups = QueryBuilder::for(Group::class)
            ->with([
                'forms',
                'createdBy',
            ])
             ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Get group of forms successfully',
            'data' => $groups,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Get group form successfully',
            'form' => [
                'name' => '',
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255|unique:groups',
        // ]);

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('groups')->where(function ($query) {
                    // Ignore soft-deleted records
                    $query->whereNull('deleted_at');
                }),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $group = new Group();
        $group->name = $request->name;
        $group->created_by = Auth::id(); 
        $group->save();

        $userLog = new UserLogController();
        $userLog->insertCreateLog('group', $group->id);

        $groupData = QueryBuilder::for(Group::class)
            ->where('id', $group->id)
            ->with([
                'forms',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'Group created successfully',
            'data' => $groupData,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $group = QueryBuilder::for(Group::class)
            ->where('id', $id)
            ->with([
                'forms',
                'createdBy',
            ])->first();

        if (!$group){
            return response()->json([
            'success' => true,
            'message' => 'Group not found',
        ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get group successfully',
            'data' => $group,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $group = QueryBuilder::for(Group::class)
            ->where('id', $id)
            ->with([
                'forms',
            ])->first();

        if (!$group){
            return response()->json([
            'success' => true,
            'message' => 'Group not found',
        ], Response::HTTP_NOT_FOUND);
        }

         return response()->json([
            'success' => true,
            'message' => 'Get group form successfully',
            'form' => [
                'name' => $group->name,
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $validator = Validator::make($request->all(), [
            // 'name' => 'required|string|max:255',
            'name' => [
                'required',
                'string',
                'max:255',
                // Rule::unique('groups')->ignore($request->id),
                Rule::unique('groups')->ignore($request->id)->where(function ($query) {
                // Ignore soft-deleted records
                $query->whereNull('deleted_at');
        }),
            ],
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'success' => false,
                'message' => 'Group not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $group->name = $request->name;
        $group->save();

        $userLog = new UserLogController();
        $userLog->insertUpdateLog('group', $group->id);

        $groupData = QueryBuilder::for(Group::class)
            ->where('id', $group->id)
            ->with([
                'forms',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'Group updated successfully',
            'data' => $groupData,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'success' => false,
                'message' => 'Group not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $group->delete();
        return response()->json([
            'success' => true,
            'message' => 'Group deleted successfully.',
        ], Response::HTTP_OK);
    }

}
