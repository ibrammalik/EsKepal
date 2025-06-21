<?php

namespace App\Traits;

use Filament\Facades\Filament;
use App\Models\User;

trait OnlyAdminKelurahan
{
  public static function canAccess(): bool
  {
    /** @var User|null $user */
    $user = Filament::auth()->user();

    return $user?->hasRole('admin_kelurahan');
  }
}
