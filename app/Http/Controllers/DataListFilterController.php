<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

use App\Models\DataListFilter;

class DataListFilterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataListFilters = QueryBuilder::for(DataListFilter::class)
        ->with([
            'dataList',
        ])
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Get data list filters successfully',
            'data' => $dataListFilters,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Get data list filters form successfully',
            'form' => [
                'list_id' => '',
                'label' => '',
                'order' => '',
                'table_name' => '',
                'column_name' => '',
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'list_id' => 'required|integer|exists:data_lists,id',
            'label' => 'required|string|max:255',
            'order' => 'required|integer',
            'table_name' => 'required|string|max:255',
            'column_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $dataListFilter = new DataListFilter();
        $dataListFilter->list_id = $request->list_id;
        $dataListFilter->label = $request->label;
        $dataListFilter->order = $request->order;
        $dataListFilter->table_name = $request->table_name;
        $dataListFilter->column_name = $request->column_name;
        $dataListFilter->save();


        $dataListFilterValue = QueryBuilder::for(DataListFilter::class)
            ->where('id', $dataListFilter->id)
            ->with([
                'dataList',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'Data List Filters created successfully',
            'data' => $dataListFilterValue,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dataListFilter = QueryBuilder::for(DataListFilter::class)
            ->where('id', $id)
            ->with([
                'dataList',
            ])->first();

        if (!$dataListFilter){
            return response()->json([
            'success' => true,
            'message' => 'Data list filters not found',
        ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get data list filters successfully',
            'data' => $dataListFilter,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dataListFilter = QueryBuilder::for(DataListFilter::class)
            ->where('id', $id)
            ->with([
                'dataList',
            ])->first();


        if (!$dataListFilter){
            return response()->json([
            'success' => true,
            'message' => 'Data list filter not found',
        ], Response::HTTP_NOT_FOUND);
        }

         return response()->json([
            'success' => true,
            'message' => 'Get data list filter form successfully',
            'form' => [
                'list_id' => $dataListFilter->list_id,
                'label' => $dataListFilter->label,
                'order' => $dataListFilter->order,
                'table_name' => $dataListFilter->table_name,
                'column_name' => $dataListFilter->column_name,
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'list_id' => 'required|integer|exists:data_lists,id',
            'label' => 'required|string|max:255',
            'order' => 'required|integer',
            'table_name' => 'required|string|max:255',
            'column_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $dataListFilter = DataListFilter::find($id);

        if (!$dataListFilter) {
            return response()->json([
                'success' => false,
                'message' => 'Data List Filter not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $dataListFilter->list_id = $request->list_id;
        $dataListFilter->label = $request->label;
        $dataListFilter->order = $request->order;
        $dataListFilter->table_name = $request->table_name;
        $dataListFilter->column_name = $request->column_name;
        $dataListFilter->save();


         $dataListFilterValue = QueryBuilder::for(DataListFilter::class)
            ->where('id', $dataListFilter->id)
            ->with([
                'dataList',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'Data list filter updated successfully',
            'data' => $dataListFilterValue,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dataListFilter = DataListFilter::find($id);

        if (!$dataListFilter) {
            return response()->json([
                'success' => false,
                'message' => 'Data list filter not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $dataListFilter->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data list filter deleted successfully.',
        ], Response::HTTP_OK);
    }

}
