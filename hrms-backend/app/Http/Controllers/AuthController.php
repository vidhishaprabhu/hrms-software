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
    ]);

    // 🔍 Check manually if email already exists (Equality Check)
    $existingUser = User::where('email', $request->email)->first();
    $existingName = User:: where('name', $request->name)->first();
    $existingPassword = User::where('password',$request->password)->first();
    if ($existingUser) {
        return response()->json([
            'errors' => ['email' => ['This email is already registered.']]
        ], 422);
    }
    if($existingName){
         return response()->json([
            'errors' => ['name' => ['This name is already registered.']]
        ], 422);       
    }
    $user=User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>bcrypt($request->password),
    ]);
        
        return response()->json(['message'=>'User registered successfully','user'=>$user]);
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
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
        $user->currentAccessToken()->delete();  // ✅ Deletes token from DB
        return response()->json(['message' => 'Logged out successfully']);
    }

    return response()->json(['message' => 'No token to delete'], 401);
}

}
