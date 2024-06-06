<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

use App\Models\DataListItem;

class DataListItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataListItems = QueryBuilder::for(DataListItem::class)
        ->with([
            'dataList',
        ])
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Get data list items successfully',
            'data' => $dataListItems,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Get data list item form successfully',
            'form' => [
                'list_id' => '',
                'label' => '',
                'order' => '',
                'column_key' => '',
                'table_name' => '',
                'column_name' => '',
                'is_hidden' => '',
                'include_filter' => '',
                'filter_type' => '',
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
            'column_key' => 'required|string|max:255',
            'table_name' => 'required|string|max:255',
            'column_name' => 'required|string|max:255',
            'is_hidden' => 'required|boolean',
            'include_filter' => 'required|boolean',
            'filter_type' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $dataListItem = new DataListItem();
        $dataListItem->list_id = $request->list_id;
        $dataListItem->label = $request->label;
        $dataListItem->order = $request->order;
        $dataListItem->column_key = $request->column_key;
        $dataListItem->table_name = $request->table_name;
        $dataListItem->column_name = $request->column_name;
        $dataListItem->is_hidden = $request->is_hidden;
        $dataListItem->include_filter = $request->include_filter;
        $dataListItem->filter_type = $request->filter_type;
        $dataListItem->save();


        $dataListItemValue = QueryBuilder::for(DataListItem::class)
            ->where('id', $dataListItem->id)
            ->with([
                'dataList',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'Data List Items created successfully',
            'data' => $dataListItemValue,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dataListItem = QueryBuilder::for(DataListItem::class)
            ->where('id', $id)
            ->with([
                'dataList',
            ])->first();

        if (!$dataListItem){
            return response()->json([
            'success' => true,
            'message' => 'Data list items not found',
        ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get data list items successfully',
            'data' => $dataListItem,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dataListItem = QueryBuilder::for(DataListItem::class)
            ->where('id', $id)
            ->with([
                'dataList',
            ])->first();


        if (!$dataListItem){
            return response()->json([
            'success' => true,
            'message' => 'Data list item not found',
        ], Response::HTTP_NOT_FOUND);
        }

         return response()->json([
            'success' => true,
            'message' => 'Get data list item form successfully',
            'form' => [
                'list_id' => $dataListItem->list_id,
                'label' => $dataListItem->label,
                'order' => $dataListItem->order,
                'column_key' => $dataListItem->column_key,
                'table_name' => $dataListItem->table_name,
                'column_name' => $dataListItem->column_name,
                'is_hidden' => $dataListItem->is_hidden,
                'include_filter' => $dataListItem->include_filter,
                'filter_type' => $dataListItem->filter_type,
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
            'column_key' => 'required|string|max:255',
            'table_name' => 'required|string|max:255',
            'column_name' => 'required|string|max:255',
            'is_hidden' => 'required|boolean',
            'include_filter' => 'required|boolean',
            'filter_type' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $dataListItem = DataListItem::find($id);

        if (!$dataListItem) {
            return response()->json([
                'success' => false,
                'message' => 'Data List Item not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $dataListItem->list_id = $request->list_id;
        $dataListItem->label = $request->label;
        $dataListItem->order = $request->order;
        $dataListItem->column_key = $request->column_key;
        $dataListItem->table_name = $request->table_name;
        $dataListItem->column_name = $request->column_name;
        $dataListItem->is_hidden = $request->is_hidden;
        $dataListItem->include_filter = $request->include_filter;
        $dataListItem->filter_type = $request->filter_type;
        $dataListItem->save();


         $dataListItemValue = QueryBuilder::for(DataListItem::class)
            ->where('id', $dataListItem->id)
            ->with([
                'dataList',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'Data list item updated successfully',
            'data' => $dataListItemValue,
        ], Response::HTTP_OK);
    }

        public function updateOrder(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'order' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $dataListItem = DataListItem::find($id);

        if (!$dataListItem) {
            return response()->json([
                'success' => false,
                'message' => 'Data List Item not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $dataListItem->order = $request->order;
        $dataListItem->save();


         $dataListItemValue = QueryBuilder::for(DataListItem::class)
            ->where('id', $dataListItem->id)
            ->with([
                'dataList',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'Data list item order updated successfully',
            'data' => $dataListItemValue,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dataListItem = DataListItem::find($id);

        if (!$dataListItem) {
            return response()->json([
                'success' => false,
                'message' => 'Data list item not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $dataListItem->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data list item deleted successfully.',
        ], Response::HTTP_OK);
    }

}
