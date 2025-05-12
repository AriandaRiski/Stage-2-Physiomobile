<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('user:id,name')
            ->get()
            ->map(function ($patient) {
                return [
                    'id' => $patient->id,
                    'user_id' => $patient->user_id,
                    'name' => $patient->user->name,
                    'medium_acquisition' => $patient->medium_acquisition,
                    'created_at' => $patient->created_at,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $patients
        ]);
    }

    public function show($id)
    {
        $patient = Patient::with('user')->find($id);

        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $patient
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'id_type' => 'required|string',
            'id_no' => 'required|string|unique:users,id_no',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date',
            'address' => 'required|string',
            'medium_acquisition' => 'required|string',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'id_type' => $validated['id_type'],
            'id_no' => $validated['id_no'],
            'gender' => $validated['gender'],
            'dob' => $validated['dob'],
            'address' => $validated['address'],
        ]);

        $patient = Patient::create([
            'user_id' => $user->id,
            'medium_acquisition' => $validated['medium_acquisition'],
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $patient->load('user')
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'id_type' => 'required|string',
            'id_no' => 'required|string|unique:users,id_no,' . $patient->user_id,
            'gender' => 'required|in:male,female',
            'dob' => 'required|date',
            'address' => 'required|string',
            'medium_acquisition' => 'required|string',
        ]);

        $patient->user->update([
            'name' => $validated['name'],
            'id_type' => $validated['id_type'],
            'id_no' => $validated['id_no'],
            'gender' => $validated['gender'],
            'dob' => $validated['dob'],
            'address' => $validated['address'],
        ]);

        $patient->update([
            'medium_acquisition' => $validated['medium_acquisition'],
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $patient->load('user')
        ]);
    }

    public function destroy($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found'
            ], 404);
        }

        $patient->user->delete();
        $patient->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Patient deleted successfully'
        ]);
    }
}
