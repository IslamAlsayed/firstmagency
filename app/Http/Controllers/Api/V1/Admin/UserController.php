<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->integer('per_page', 20), 100);
        $users = User::orderBy('created_at', 'desc')->paginate($perPage);

        return $this->paginatedResponse($users, fn($u) => new UserResource($u));
    }

    public function show(int $id): JsonResponse
    {
        $user = User::find($id);

        return $user
            ? $this->successResponse(new UserResource($user))
            : $this->notFoundResponse('User not found.');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', Password::min(8)->mixedCase()],
            'role'     => ['required', 'in:admin,superadmin,user,support,content_manager'],
            'mobile'   => ['nullable', 'string', 'max:20'],
            'phone'    => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            ...$validated,
            'password' => Hash::make($validated['password']),
        ]);

        return $this->successResponse(new UserResource($user), 'User created.', 201);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $user = User::find($id);

        if (! $user) {
            return $this->notFoundResponse('User not found.');
        }

        $validated = $request->validate([
            'name'   => ['sometimes', 'required', 'string', 'max:255'],
            'email'  => ['sometimes', 'required', 'email', "unique:users,email,{$id}"],
            'role'   => ['sometimes', 'required', 'in:admin,superadmin,user,support,content_manager'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'phone'  => ['nullable', 'string', 'max:20'],
        ]);

        $user->update($validated);

        return $this->successResponse(new UserResource($user), 'User updated.');
    }

    public function destroy(int $id): JsonResponse
    {
        $user = User::find($id);

        if (! $user) {
            return $this->notFoundResponse('User not found.');
        }

        $user->delete();

        return $this->successResponse(null, 'User deleted.');
    }
}
