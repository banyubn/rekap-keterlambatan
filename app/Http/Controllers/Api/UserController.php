<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function all(Request $request)
    {
        $users = User::query();

        if ($request->role) {
            $users->where('role', $request->role);
        }

        $users = $users->get();

        if (!$users) {
            return $this->response_json(false, null, 'Data not available', null, null);
        }

        return $this->response_json(true, null, 'Success', $users, null);
    }

    public function table(Request $request)
    {
        $users = User::query();

        if ($request->search) {
            $users->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%")
                ->orWhere('role', 'like', "%{$request->search}%");
        }

        $users = $users->orderBy('created_at', 'DESC')->paginate($request->per_page);

        return $this->response_json(true, null, 'Table Success', $users, null);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:64',
            'email' => 'required|email',
            'role' => 'required|in:admin,ps',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);

        return $this->response_json(true, null, 'Create Success', $user, null);
    }

    public function show(String $id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->response_json(false, null, 'Data not available', null, null);
        }

        return $this->response_json(true, null, 'Show Success', $user, null);
    }

    public function update(Request $request, String $id)
    {
        $request->validate([
            'name' => 'required|string|max:64',
            'email' => 'required|email',
            'role' => 'required|in:admin,ps',
        ]);

        $user = User::find($id);

        if (!$user) {
            return $this->response_json(false, null, 'Data not available', null, null);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return $this->response_json(true, null, 'Update Success', $user, null);
    }
    public function response_json($success = false, $error = null, $message = '', $data = null, $filter = null)
    {
        $response = [
            'success' => $success,
            'error' => $error,
            'message' => $message,
            'data' => $data
        ];

        if ($filter) {
            $response['filter'] = $filter;
        }

        return response()->json($response);
    }
}
