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

use App\Models\UserLog;

class UserLogController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function insertCreateLog(string $type, string $change_id)
    {
        $userLog = new UserLog();
        $userLog->user_id = Auth::id(); 
        $userLog->action = "create"; 
        $userLog->type = $type;
        $userLog->change_id = $change_id;
        $userLog->save();

        $userLogData = QueryBuilder::for(UserLog::class)
            ->where('id', $userLog->id)
            ->with([
                'user',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'User log inserted successfully',
            'data' => $userLogData,
        ], Response::HTTP_CREATED);
    }

    public function insertUpdateLog(string $type, string $change_id)
    {
        $userLog = new UserLog();
        $userLog->user_id = Auth::id(); 
        $userLog->action = "update"; 
        $userLog->type = $type;
        $userLog->change_id = $change_id;
        $userLog->save();

        $userLogData = QueryBuilder::for(UserLog::class)
            ->where('id', $userLog->id)
            ->with([
                'user',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'User log inserted successfully',
            'data' => $userLogData,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function showLog(string $type, string $change_id)
    {
        $userLog = QueryBuilder::for(UserLog::class)
            ->where('type', $type)
            ->where('change_id', $change_id)
            ->with([
                'user',
            ])->first();

        if (!$userLog){
            return response()->json([
            'success' => true,
            'message' => 'User log not found',
        ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get user log successfully',
            'data' => $userLog,
        ], Response::HTTP_OK);
    }

}
