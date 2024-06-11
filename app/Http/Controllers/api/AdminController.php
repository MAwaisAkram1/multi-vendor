<?php

namespace App\Http\Controllers\api;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function register(Request $request) {
        $data = $request->all();
        // if (Admin::count() > 0) {
        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Admin is created successfully',
        //     ], 201);
        // }
        $admin = Admin::registerAdmin($data);

        $admin->save();
        return response()->json([
            'message' => 'Admin Successfully registered',
        ], 201);
    }

    public function login(Request $request) {
        $data = $request->only(['email', 'password']);
        try {
            $admin = Admin::loginAdmin($data);
            if(!$admin) {
                return response()->json([
                    'message'=> 'invalid Credentials',
                ], 401);
            }
            // dd($admin);
            Auth::login($admin);
            $token = Str::random(64);
            $admin->token()->create(['token' => $token]);
            return response()->json([
                'message' => 'Admin Successfully Logged In',
                'token' => $token,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message'=> $e->getMessage(),
            ], 500);
        }

    }
}
