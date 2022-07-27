<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\mst_users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = mst_users::select('name', 'email')->get();
        return response()->json([
            'data' => $users,
            'status' => 200,
            'message' => 'Get data successfully!'
        ]);
    }
    public function show($id)
    {
        $user = mst_users::select('name', 'email')->find($id);
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found!'
            ]);
        }
        return response()->json([
            'data' => $user,
            'status' => 200,
            'message' => 'Get data successfully!'
        ]);
    }
    public function store(Request $request)
    {
        $user = mst_users::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'group_role' => $request->group_role
            ]
        );
        return response()->json([
            'data' => $user,
            'status' => 201,
            'message' => 'Created data successfully!'
        ]);
    }
    public function update(Request $request, $id)
    {
        $user = mst_users::find($id);
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found!'
            ]);
        }
        $user->update(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'group_role' => $request->group_role
            ]
        );
        return response()->json([
            'data' => $user,
            'status' => 200,
            'message' => 'Updated data successfully!'
        ]);
    }
    public function destroy($id)
    {
        $user = mst_users::find($id);
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found!'
            ]);
        }
        $user->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Deleted data successfully!'
        ]);
    }
}
