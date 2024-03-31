<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = QueryBuilder::for(Role::class)
            ->with([
                'permissions',
            ])->get();

        return response()->json([
            'success' => true,
            'message' => 'Get roles successfully',
            'data' => $roles,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Get role form successfully',
            'form' => [
                'name' => '',
                'permissions' => ''
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $role = new Role();
        $role->name = $request->name;
        $role->save();

         $permissions = $request->permissions;
          foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }

        $roleData = QueryBuilder::for(Role::class)
            ->where('name', $role->name)
            ->with([
                'permissions',
            ])->first();
        return response()->json([
            'success' => true,
            'message' => 'Role created successfully',
            'data' => $roleData,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = QueryBuilder::for(Role::class)
            ->where('id', $id)
            ->with([
                'permissions',
            ])->first();

        if (!$role){
            return response()->json([
            'success' => true,
            'message' => 'Role not found',
        ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get role successfully',
            'data' => $role,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $role = Role::where('id', $id)->first();
         $role = QueryBuilder::for(Role::class)
            ->where('id', $id)
            ->with([
                'permissions',
            ])->first();

        if (!$role){
            return response()->json([
            'success' => true,
            'message' => 'Role not found',
        ], Response::HTTP_NOT_FOUND);
        }

         return response()->json([
            'success' => true,
            'message' => 'Get role form successfully',
            'form' => [
                'name' => $role->name,
                'permissions'=> $role->permissions,
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->ignore($request->id),
            ]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $role->name = $request->name;
        $role->save();

         // Revoke all existing permissions for the role
        $role->permissions()->detach();

        $permissions = $request->permissions;
        foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
        }

        $roleData = QueryBuilder::for(Role::class)
            ->where('name', $role->name)
            ->with([
                'permissions',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully',
            'data' => $roleData,
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $role->delete();
        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully.',
        ], Response::HTTP_OK);
    }
    
}


//  public function assignPermissionToRole(Request $request, string $id)
//     {   
//         try {
//             $roleName = $request->role;
//             $permissions = $request->permissions;

//             $role = Role::where('name', $roleName)->first();

//             if (!$role) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Role not found',
//                 ], Response::HTTP_NOT_FOUND);
//             }

//              // Revoke all existing permissions for the role
//             $role->permissions()->detach();

//             // Give each permission to the role
//             foreach ($permissions as $permission) {
//                 $role->givePermissionTo($permission);
//             }

//             return response()->json([
//                 'success' => true,
//                 'message' => 'Permissions have been assigned to role',
//                 'data' => $role,
//             ], Response::HTTP_CREATED);
//         } catch (\Exception $e) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Error assigning permissions to role: ' . $e->getMessage(),
//             ], Response::HTTP_INTERNAL_SERVER_ERROR);
//         }
//     }