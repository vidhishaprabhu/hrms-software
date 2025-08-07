<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'email' => 'required|email',
        'password' => 'required|min:6',
        'role' => 'required|in:admin,user,hr,employee'
 
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // 🔍 Check manually for duplicates
    if (User::where('email', $request->email)->exists()) {
        return response()->json([
            'errors' => ['email' => ['This email is already registered.']]
        ], 422);
    }

    if (User::where('name', $request->name)->exists()) {
        return response()->json([
            'errors' => ['name' => ['This name is already registered.']]
        ], 422);
    }

    // ✅ Create new user with role
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role, 
    ]);

    return response()->json([
        'message' => 'User registered successfully',
        'user' => $user
    ]);
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $user=User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'user'=>$user,
            'token' => $token
        ],200);
    }
    // AuthController.php

public function logout(Request $request)
{
    $user = $request->user();

    if ($user && $user->currentAccessToken()) {
        $user->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    return response()->json(['message' => 'No token to delete'], 401);
}
public function user(Request $request)
{
    return response()->json($request->user());
}
}
