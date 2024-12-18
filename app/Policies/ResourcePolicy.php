<?php

namespace App\Policies;

use App\Models\User;

class ResourcePolicy
{
    /**
     * Create a new policy instance.
     */
  public function update(User $user)
{
    // Batasi akses jika email pengguna berakhiran @gmail.com
    if (str_ends_with($user->email, '@gmail.com')) {
        return false; // Tidak bisa mengedit
    }
    return true; // Bisa mengedit
}

public function delete(User $user)
{
    // Batasi akses jika email pengguna berakhiran @gmail.com
    if (str_ends_with($user->email, '@gmail.com')) {
        return false; // Tidak bisa menghapus
    }
    return true; // Bisa menghapus
}
};