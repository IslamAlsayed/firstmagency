<?php

return [
    'accepted' => 'The :attribute field must be accepted.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'email' => 'The :attribute field must be a valid email address.',
    'max' => [
        'numeric' => 'The :attribute field must not be greater than :max.',
        'file' => 'The :attribute field must not be greater than :max kilobytes.',
        'string' => 'The :attribute field must not be greater than :max characters.',
        'array' => 'The :attribute field must not have more than :max items.',
    ],
    'min' => [
        'numeric' => 'The :attribute field must be at least :min.',
        'file' => 'The :attribute field must be at least :min kilobytes.',
        'string' => 'The :attribute field must be at least :min characters.',
        'array' => 'The :attribute field must have at least :min items.',
    ],
    'required' => 'The :attribute field is required.',
    'string' => 'The :attribute field must be a string.',
    'unique' => 'The :attribute has already been taken.',

    'attributes' => [
        'name' => 'name',
        'email' => 'email',
        'password' => 'password',
        'password_confirmation' => 'password confirmation',
        'current_password' => 'current password',
        'phone' => 'phone',
        'mobile' => 'mobile',
        'address' => 'address',
        'subject' => 'subject',
        'message' => 'message',
    ],
];
