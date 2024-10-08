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
        $verificationToken = $user->userTokens()->create([
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
     * @param User|\Illuminate\Auth\Authenticatable $user
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    static function sendPasswordResetLink(mixed $user): \Illuminate\Database\Eloquent\Model|null
    {
        $resetToken = $user->userTokens()->create([
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

    /**
     * Summary of updateAvatar
     * @param User|\Illuminate\Auth\Authenticatable $user
     * @param array $validated
     * @return string|null
     */
    static function updateAvatar(mixed $user, array $validated): string|null
    {
        if ($user->avatar) {
            // delete old avatar
            self::deleteAvatar($user);
        }

        /**
         * @var \Illuminate\Http\UploadedFile $avatar
         */
        $avatar = $validated['file'];
        $user->avatar = $avatar->store('avatars');

        is_string($user->avatar) ? $user->save() : $user->avatar = null;

        return $user->avatar;
    }

    /**
     * Delete avatar
     * @param mixed $user
     * @return bool
     */
    static function deleteAvatar(mixed $user): bool
    {
        if ($user->avatar && \Storage::fileExists($user->avatar)) {
            \Storage::delete($user->avatar);
        }

        $user->avatar = null;

        return $user->save();
    }
}
