<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountsController extends Controller
{
    public function index(Request $request)
    {
        $adminId = $request->query('admin_id');
        $username = $request->query('username');
        $status = $request->query('status');
        $entries = $request->query('entries', 10);

        $query = User::query();

        if ($adminId) {
            $query->where('id', $adminId);
        }
        if ($username) {
            $query->where('username', 'like', '%' . $username . '%');
        }
        if ($status) {
            $query->where('status', $status);
        }

        $accounts = $query->paginate($entries);

        if ($request->ajax()) {
            return view('accounts.partials.table', compact('accounts'))->render();
        }

        return view('accounts.index', compact('accounts'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = $request->input('status');
        $user->save();

        return redirect()->route('accounts.index')->with('success', 'Account status updated successfully.');
    }
}