<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'age' => 'required|min:1|max:99'
            ]);
            $user = User::create($data);
            return response()->json($user, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Invalid data',
                'error' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }

    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'User is not found',
                'error' => $e->getMessage()
            ], 404);
        }        
    }

    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $data = $request->validate([
                'name' => 'string',
                'email' => 'email|unique:users',
                'age' => 'min:1|max:99'
            ]);
            $user->update($data);
            return response()->json($user);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Invalid data',
                'error' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }

    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'success' => 'User was deleted'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }
}
