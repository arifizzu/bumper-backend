<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

use App\Models\DataListAction;

class DataListActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataListActions = QueryBuilder::for(DataListAction::class)
        ->with([
            'dataList',
        ])
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Get data list actions successfully',
            'data' => $dataListActions,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Get data list action form successfully',
            'form' => [
                'list_id' => '',
                'name' => '',
                'segment' => '',
                'order' => '',
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
            'name' => 'required|string|max:255',
            'segment' => 'required|string|max:255',
            'order' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $dataListAction = new DataListAction();
        $dataListAction->list_id = $request->list_id;
        $dataListAction->name = $request->name;
        $dataListAction->order = $request->order;
        $dataListAction->segment = $request->segment;
        $dataListAction->save();


        $dataListActionValue = QueryBuilder::for(DataListAction::class)
            ->where('id', $dataListAction->id)
            ->with([
                'dataList',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'Data List Actions created successfully',
            'data' => $dataListActionValue,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dataListAction = QueryBuilder::for(DataListAction::class)
            ->where('id', $id)
            ->with([
                'dataList',
            ])->first();

        if (!$dataListAction){
            return response()->json([
            'success' => true,
            'message' => 'Data list actions not found',
        ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get data list actions successfully',
            'data' => $dataListAction,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dataListAction = QueryBuilder::for(DataListAction::class)
            ->where('id', $id)
            ->with([
                'dataList',
            ])->first();


        if (!$dataListAction){
            return response()->json([
            'success' => true,
            'message' => 'Data list action not found',
        ], Response::HTTP_NOT_FOUND);
        }

         return response()->json([
            'success' => true,
            'message' => 'Get data list action form successfully',
            'form' => [
                'list_id' => $dataListAction->list_id,
                'name' => $dataListAction->name,
                'order' => $dataListAction->order,
                'segment' => $dataListAction->segment,
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
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'segment' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $dataListAction = DataListAction::find($id);

        if (!$dataListAction) {
            return response()->json([
                'success' => false,
                'message' => 'Data List Action not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $dataListAction->list_id = $request->list_id;
        $dataListAction->name = $request->name;
        $dataListAction->order = $request->order;
        $dataListAction->segment = $request->segment;
        $dataListAction->save();


         $dataListActionValue = QueryBuilder::for(DataListAction::class)
            ->where('id', $dataListAction->id)
            ->with([
                'dataList',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'Data list action updated successfully',
            'data' => $dataListActionValue,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dataListAction = DataListAction::find($id);

        if (!$dataListAction) {
            return response()->json([
                'success' => false,
                'message' => 'Data list action not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $dataListAction->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data list action deleted successfully.',
        ], Response::HTTP_OK);
    }

}
