<?php

namespace App\Http\Controllers;


use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve filter and search parameters
        $adminId = $request->query('admin_id');
        $username = $request->query('username');
        $status = $request->query('status');
        $search = $request->query('search');

        // Build the query
        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        if ($adminId) {
            $query->where('id', 'like', "%{$adminId}%");
        }

        if ($username) {
            $query->where('username', 'like', "%{$username}%");
        }

        if ($status) {
            $query->where('status', $status);
        }

        // Get the filtered accounts
        $accounts = $query->get();

        // Log the action to audit log
        $this->logAuditAction('Viewed accounts list', [
            'filters' => compact('adminId', 'username', 'status', 'search')
        ]);

        // Return the view or partial for AJAX
        if ($request->ajax()) {
            return view('accounts.partials.table', compact('accounts'))->render();
        }

        return view('accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new account.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Store a newly created account in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:Active,Inactive',
        ]);

        // Create the user
        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'status' => $validated['status'],
        ]);

        // Log the action to audit log
        $this->logAuditAction('Created account', [
            'user_id' => $user->id,
            'username' => $user->username,
        ]);

        return redirect()->route('accounts.index')->with('success', 'Account created successfully.');
    }

    /**
     * Update the specified account's status.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        // Validate the request
        $validated = $request->validate([
            'status' => 'required|in:Active,Inactive',
        ]);

        // Update the user's status
        $user->update([
            'status' => $validated['status'],
        ]);

        // Log the action to audit log
        $this->logAuditAction("Updated account status to {$validated['status']}", [
            'user_id' => $user->id,
            'username' => $user->username,
        ]);

        return redirect()->route('accounts.index')->with('success', 'Account status updated successfully.');
    }

    /**
     * Log an action to the audit log.
     *
     * @param string $action
     * @param array $details
     * @return void
     */
    protected function logAuditAction(string $action, array $details = [])
    {
        try {
            AuditLog::create([
                'admin_id' => Auth::id(),
                'action' => $action,
                'details' => json_encode($details),
                'timestamp' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log audit action: ' . $e->getMessage());
        }
    }
}

