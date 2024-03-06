<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

use App\Models\FormTemplate;

class FormTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showAllTemplateForm(Request $request)   //index
    {
        $formTemplate = FormTemplate::all();
        return response()->json([
            'success' => true,
            'message' => 'Get template forms successfully',
            'data' => $formTemplate,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function saveFormAsTemplate(Request $request)    //store
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:forms,id',      //form_id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $formTemplate = new FormTemplate();
        $formTemplate->form_id = $request->id;
        $formTemplate->save();

        return response()->json([
            'success' => true,
            'message' => 'Form saved as template successfully',
            'data' => $formTemplate,
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteTemplateForm(string $id)      //destroy
    {
        $formTemplate = FormTemplate::find($id);

        if (!$formTemplate) {
            return response()->json([
                'success' => false,
                'message' => 'Template form not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $formTemplate->delete();
        return response()->json([
            'success' => true,
            'message' => 'Template form deleted successfully.',
        ], Response::HTTP_OK);
    }
}
