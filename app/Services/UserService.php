<?php

namespace App\Services;

use App\Models\User;

class UserService extends AbstractResourceService
{
    public function __construct()
    {
        parent::__construct(new User());
    }
}
