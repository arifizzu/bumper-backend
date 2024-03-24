<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Schema;

class DatabaseRetrievalController extends Controller
{
    public function getTables()
    {
        $tables = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

        return response()->json([
            'success' => true,
            'message' => 'Get database table successfully',
            'data' => $tables,
        ], Response::HTTP_OK);
    }

    public function getColumns(Request $request)
    {
        $tableName = $request->tableName;
        $columns = Schema::getColumnListing($tableName);

         if (!$columns){
            return response()->json([
            'success' => true,
            'message' => 'Columns not found',
        ], Response::HTTP_NOT_FOUND);
        }

        // sort($columns);

        return response()->json([
            'success' => true,
            'message' => 'Get database column for table ' . $tableName . ' successfully',
            'data' => $columns,
        ], Response::HTTP_OK);
    }

    public function getLatestId(Request $request) {
         $tableName = $request->tableName;
        $latestId = DB::table($tableName)->max('id');

        if (!$latestId){
            return response()->json([
            'success' => true,
            'message' => 'Latest id not found for table ' . $tableName,
        ], Response::HTTP_NOT_FOUND);
        }

    return response()->json([
            'success' => true,
            'message' => 'Latest id found successfully for table ' . $tableName,
            'data' => $latestId,
        ], Response::HTTP_OK);
    }

}