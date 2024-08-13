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
            $createdUser = self::sendVerificationEmail($createdUser);
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

    /**
     * Delete user
     * @param User|\Illuminate\Auth\Authenticatable $user
     * @param mixed $user
     * @return bool
     */
    static function delete(mixed $user): bool
    {
        // remove photo

        // do something

        return $user->delete();
    }

    /**
     * Generate a verification token to user
     * @param User|\Illuminate\Auth\Authenticatable $user
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    static function sendVerificationEmail(mixed $user): \Illuminate\Database\Eloquent\Model|null
    {
        $verificationToken = $user->tokens()->create([
            'to' => 'email_verification',
            'token' => md5(\Str::random())
        ]);

        if (!$verificationToken) {
            return null;
        }

        \Mail::to($user)->send(
            new \App\Mail\Auth\EmailVerificationMail($user, $verificationToken)
        );

        return $user;
    }

    /**
     * Send password reset link
     * @param mixed $user
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    static function sendPasswordResetLink(mixed $user): \Illuminate\Database\Eloquent\Model|null
    {
        $resetToken = $user->tokens()->create([
            'to' => 'password_reset',
            'token' => md5(\Str::random())
        ]);

        if (!$resetToken) {
            return null;
        }

        \Mail::to($user)->send(
            new \App\Mail\Auth\PasswordResetLinkMail($user, $resetToken)
        );

        return $user;
    }
}
