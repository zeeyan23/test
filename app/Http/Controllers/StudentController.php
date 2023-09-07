<?php

namespace App\Http\Controllers;

use App\Models\testModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_names = testModel::all();
        
        return response()->json($all_names);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->json()->all();

        $testModel = new testModel();

        if (isset($data['text'])) {
            $testModel->firstname = $data['text']; // Assign the value from the request data
        } else {
            return response()->json(['message' => 'Missing "text" data'], 400);
            // Return a 400 Bad Request response if 'text' is missing
        }

        if ($testModel->save()) {
            return response()->json(['message' => 'Data saved successfully'], 201);
        } else {
            return response()->json(['message' => 'Failed to save data'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json([
            
            'success' => true,
            'message' => 'Student record updated successfully.',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
        ]);
    
        $student = testModel::findOrFail($id);
    
        $student->update([
            'firstname' => $validatedData['firstname'],
        ]);
        return response()->json(['message' => 'Student updated successfully.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $testModel = testModel::find($id);

        if (!$testModel) {
            return response()->json(['message' => 'Model not found'], 404);
        }else{
            $testModel->delete();
        }
        
        return response()->json(['message' => 'Data deleted successfully'], 200);
    }

}
