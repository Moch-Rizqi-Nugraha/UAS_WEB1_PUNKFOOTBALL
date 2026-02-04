<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = ['admin', 'user', 'moderator'];
        return view('admin.roles.index', compact('roles'));
    }

    public function edit(User $user)
    {
        $roles = ['admin', 'user', 'moderator'];
        return view('admin.roles.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,user,moderator',
        ]);
        $user->role = $request->role;
        $user->save();
        return redirect()->route('admin.users.show', $user->id)->with('success', 'Role updated successfully.');
    }
}
