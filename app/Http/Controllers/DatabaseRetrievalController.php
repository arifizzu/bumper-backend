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
        return response()->json([
            'success' => true,
            'message' => 'Get database column for table ' . $tableName . ' successfully',
            'data' => $columns,
        ], Response::HTTP_OK);
    }
}