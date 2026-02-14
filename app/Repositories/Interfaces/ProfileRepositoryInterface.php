<?php

namespace App\Repositories\Interfaces;

use App\Models\Profile;

interface ProfileRepositoryInterface extends RepositoryInterface
{
    public function getPrimary(): ?Profile;
}
