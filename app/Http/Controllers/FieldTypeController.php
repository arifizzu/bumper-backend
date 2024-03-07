<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

use App\Models\FieldType;

class FieldTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showAllFieldTypes(Request $request)         //index
    {
        $fieldTypes = FieldType::all();
        return response()->json([
            'success' => true,
            'message' => 'Get field types successfully',
            'data' => $fieldTypes,
        ], Response::HTTP_OK);
    }
}
