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

        $tablesToExclude = ['activities', 'activities_relations', 'activities_locations', 'conditions', 'failed_jobs', 'fields', 'fields_locations', 'fields_lists_values',
         'fields_types','forms', 'forms_templates', 'forms_logs', 'groups', 'migrations', 'model_has_permissions', 'model_has_roles', 'participants',
         'participant_is_role', 'participant_is_user', 'password_reset_tokens', 'permissions', 'personal_access_tokens', 'processes',
        'roles', 'role_has_permissions', 'users', 'users_logs', 'data_lists', 'data_lists_actions', 'data_lists_filters', 'data_lists_items'];

        $filteredTables = array_values(array_filter($tables, function ($tableName) use ($tablesToExclude) {
            return !in_array($tableName, $tablesToExclude);
        }));

        return response()->json([
            'success' => true,
            'message' => 'Get database table successfully',
            'data' => $filteredTables,
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