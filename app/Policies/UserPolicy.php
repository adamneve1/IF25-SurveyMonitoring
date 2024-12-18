<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can update records.
     */
    public function update(User $user): bool
    {
        // Blokir akses jika email pengguna berakhiran @gmail.com
        return !str_ends_with($user->email, '@gmail.com');
    }

    /**
     * Determine whether the user can delete records.
     */
    public function delete(User $user): bool
    {
        // Blokir akses jika email pengguna berakhiran @gmail.com
        return !str_ends_with($user->email, '@gmail.com');
    }
}
