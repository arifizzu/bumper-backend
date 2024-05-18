<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

use App\Models\DataList;

class DataListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataLists = QueryBuilder::for(DataList::class)
        ->with([
            'items',
            'filters',
            'form',
        ])
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Get data lists successfully',
            'data' => $dataLists,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Get data lists form successfully',
            'form' => [
                'title' => '',
                'description' => '',
                'form_id' => '',
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'form_id' => 'nullable|integer|exists:forms,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $dataList = new DataList();
        $dataList->title = $request->title;
        $dataList->description = $request->description;
        $dataList->form_id = $request->form_id;
        $dataList->save();


         $dataListValue = QueryBuilder::for(DataList::class)
            ->where('id', $dataList->id)
            ->with([
                'items',
                'filters',
                'form',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'Data List created successfully',
            'data' => $dataListValue,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dataList = QueryBuilder::for(DataList::class)
            ->where('id', $id)
            ->with([
                'items',
                'filters',
                'form',
            ])->first();

        if (!$dataList){
            return response()->json([
            'success' => true,
            'message' => 'Data list not found',
        ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get data list successfully',
            'data' => $dataList,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dataList = QueryBuilder::for(DataList::class)
            ->where('id', $id)
            ->with([
                'items',
                'filters',
                'form',
            ])->first();


        if (!$dataList){
            return response()->json([
            'success' => true,
            'message' => 'Data list not found',
        ], Response::HTTP_NOT_FOUND);
        }

         return response()->json([
            'success' => true,
            'message' => 'Get data list form successfully',
            'form' => [
                'title' => $dataList->title,
                'description' => $dataList->description,
                'form_id' => $dataList->form_id,
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'form_id' => 'nullable|integer|exists:forms,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $dataList = DataList::find($id);

        if (!$dataList) {
            return response()->json([
                'success' => false,
                'message' => 'Data List not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $dataList->title = $request->title;
        $dataList->description = $request->description;
        $dataList->form_id = $request->form_id;
        $dataList->save();


         $dataListValue = QueryBuilder::for(DataList::class)
            ->where('id', $dataList->id)
            ->with([
                'items',
                'filters',
                'form',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'Data list updated successfully',
            'data' => $dataListValue,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dataList = DataList::find($id);

        if (!$dataList) {
            return response()->json([
                'success' => false,
                'message' => 'Data list not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $dataList->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data list deleted successfully.',
        ], Response::HTTP_OK);
    }

}
