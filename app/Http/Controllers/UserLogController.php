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
                ->whereHas('user', function ($query) {
                    $query->where('id', '!=', 1);
                })
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->get();

            // Load the related model data based on the type
        $userLogs->each(function ($log) {
            switch ($log->type) {
                case 'form':
                    $log->related = Form::find($log->change_id);
                    break;
                case 'datalist':
                    $log->related = Datalist::find($log->change_id);
                    break;
                case 'process':
                    $log->related = Process::find($log->change_id);
                    break;
                case 'group':
                    $log->related = Group::find($log->change_id);
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
