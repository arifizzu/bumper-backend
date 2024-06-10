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

use App\Models\FormLog;

class FormLogController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function insertCreateLog(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'form_id' => 'required|integer|exists:forms,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $formLog = new FormLog();
        $formLog->user_id = $request->user_id;
        $formLog->form_id = $request->form_id;
        $formLog->save();

        $formLogData = QueryBuilder::for(FormLog::class)
            ->with([
                'user',
                'form',
            ])->first();

        return response()->json([
            'success' => true,
            'message' => 'Form log inserted successfully',
            'data' => $formLogData,
        ], Response::HTTP_CREATED);
    }


    /**
     * Display the specified resource.
     */
    public function showFormLog(Request $request)
    {
        $formLog = QueryBuilder::for(FormLog::class)
            ->withTrashed() // Includes soft-deleted FormLog entries
            ->with([
                'user' => function ($query) {
                    $query->withTrashed(); // Includes soft-deleted users
                },
                'form' => function ($query) {
                    $query->withTrashed(); // Includes soft-deleted forms
                },
            ])
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Get form log successfully',
            'data' => $formLog,
        ], Response::HTTP_OK);
    }
}
