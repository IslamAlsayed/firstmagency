<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $this->route('user'),
            'email_verified_at' => 'nullable|date',
            'password' => 'nullable|string|min:8|confirmed',
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:500',
            'mobile' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'role' => 'nullable|string|in:user,admin,superadmin',
            'last_login_ip' => 'nullable|ip',
            'last_login_at' => 'nullable|date',
            'password_changed_at' => 'nullable|date',
            'status' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|integer|exists:users,id',
            'updated_by' => 'nullable|integer|exists:users,id',
        ];
    }
}
