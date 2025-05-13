<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\AuditLog;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index()
    {
        $users = User::all();
        $activePage = 'accounts';
        return view('enrollment.accounts', compact('users', 'activePage'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status' => 'Active',
        ]);

        // Log the account creation
        AuditLog::create([
            'user_id' => Auth::id() ?? null,
            'action' => 'create_account',
            'description' => 'Created account with username: ' . $request->username,
        ]);

        Log::info('Account created', ['username' => $request->username, 'by' => Auth::id() ?? 'unknown']);

        return redirect()->route('accounts.index')->with('success', 'Admin account created successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Active,Deactivated',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Find the user
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }

        // Update the status
        $user->status = $request->status;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
        ]);
    }
}
