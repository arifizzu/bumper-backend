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
use App\Models\Form;
use App\Models\Datalist;
use App\Models\Process;
use App\Models\Group;

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

    public function insertDeleteLog(string $type, string $change_id)
    {
        $userLog = new UserLog();
        $userLog->user_id = Auth::id();
        $userLog->action = "delete";
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
    public function showUserLog(Request $request)
    {
        $userLogs = QueryBuilder::for(UserLog::class)
            ->withTrashed()
            // ->whereHas('user', function ($query) {
            //     $query->where('id', '!=', 1);
            // })
            ->with(['user' => function ($query) {
                $query->withTrashed(); // Includes soft-deleted users
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        // Load the related model data based on the type
        $userLogs->each(function ($log) {
            switch ($log->type) {
                case 'form':
                    $log->related = Form::withTrashed()->find($log->change_id); // Include soft-deleted forms
                    break;
                case 'datalist':
                    $log->related = Datalist::withTrashed()->find($log->change_id); // Include soft-deleted datalists
                    break;
                case 'process':
                    $log->related = Process::withTrashed()->find($log->change_id); // Include soft-deleted processes
                    break;
                case 'group':
                    $log->related = Group::withTrashed()->find($log->change_id); // Include soft-deleted groups
                    break;
                default:
                    $log->related = null;
                    break;
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Get user log successfully',
            'data' => $userLogs,
        ], Response::HTTP_OK);
    }
}
