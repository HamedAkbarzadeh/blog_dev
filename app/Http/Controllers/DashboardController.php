<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function user() {
        return auth()->user();
    }

    public function userUpdate(Request $request) {
        
        $user = auth()->user();
        $user_id = $user->id;
        // dd($user_id);
        $original_user = User::findOrFail($user_id);

        $original_user->update($request->all());


        return response()->json([
            'user' => $original_user,
            'successfull update'
        ]);
    }
}
