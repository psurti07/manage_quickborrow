<?php

namespace Modules\Auth\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\App\Models\Administrations;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth::index');
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'emailid' => 'required|email',
            'password' => 'required'
        ]);
        
        // Find the user first with email and isdelete = 0
        $user = Administrations::where('emailid', $credentials['emailid'])
                    ->where('isDelete', 0)
                    ->first();
    
        if ($user && Auth::attempt(['emailid' => $credentials['emailid'], 'password' => $credentials['password']])) {
            return response()->json([
                'type' => 'SUCCESS',
                'redirect' => route('manage.dashboard')
            ]);
        } else {
            return response()->json([
                'type' => 'ERROR',
                'message' => 'Invalid login credentials or account is deleted'
            ]);
        }
    }
}
