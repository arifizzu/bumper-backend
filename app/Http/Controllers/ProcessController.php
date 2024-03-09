<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Process;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $processes = QueryBuilder::for(Process::class)
            // ->with([
            //     'activities',
            // ])
            ->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Get process successfully',
            'data' => $processes,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Get process form successfully',
            'form' => [
                'name' => '',
                'short_name' => '',
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:processes',
            'short_name' => 'required|string|max:255|unique:processes',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $process = new Process();
        $process->name = $request->name;
        $process->short_name = $request->short_name;
        $process->save();

        return response()->json([
            'success' => true,
            'message' => 'Process created successfully',
            'data' => $process,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $process = QueryBuilder::for(Process::class)
            ->where('id', $id)
            // ->with([
            //     'activities',
            // ])
            ->first();

        if (!$process){
            return response()->json([
            'success' => true,
            'message' => 'Process not found',
        ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get process successfully',
            'data' => $process,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $process = Process::where('id', $id)->first();

        if (!$process){
            return response()->json([
            'success' => true,
            'message' => 'Process not found',
        ], Response::HTTP_NOT_FOUND);
        }

         return response()->json([
            'success' => true,
            'message' => 'Get process successfully',
            'form' => [
                'name' => $process->name,
                'short_name' => $process->short_name,
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
                Rule::unique('processes')->ignore($request->id),
            ],
            'short_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('processes')->ignore($request->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $process = Process::find($id);

        if (!$process) {
            return response()->json([
                'success' => false,
                'message' => 'Process not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $process->name = $request->name;
        $process->short_name = $request->short_name;
        $process->save();

        return response()->json([
            'success' => true,
            'message' => 'Process updated successfully',
            'data' => $process,
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $process = Process::find($id);

        if (!$process) {
            return response()->json([
                'success' => false,
                'message' => 'Process not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $process->delete();
        return response()->json([
            'success' => true,
            'message' => 'Process deleted successfully.',
        ], Response::HTTP_OK);
    }
}
