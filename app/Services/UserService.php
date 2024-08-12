<?php

namespace App\Services;

use App\Models\User;

class UserService extends BaseService
{
    /**
     * Create user
     * @param array $validated
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    static function create(array $validated = []): \Illuminate\Database\Eloquent\Model|null
    {
        $createdUser = User::create($validated);

        // Do something with $createdUser, like send verification email, etc.
        if (isset($validated['send_verification_mail']) && $validated['send_verification_mail']) {
            // Generate a verification token
            $createdUser->verification_token = \Str::random();
            $createdUser->save();

            // Send verification mail
            \Mail::to($createdUser)->send(
                new \App\Mail\Auth\EmailVerificationMail($createdUser)
            );
        }

        return $createdUser;
    }

    /**
     * Update user
     * @param User|\Illuminate\Auth\Authenticatable $user
     * @param array $validated
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    static function update(mixed $user, array $validated = []): \Illuminate\Database\Eloquent\Model|null
    {
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        if (!$user->update($validated)) {
            return null;
        }

        $updatedUser = $user->fresh();

        // Do something with $updatedUser.

        return $updatedUser;
    }
}
