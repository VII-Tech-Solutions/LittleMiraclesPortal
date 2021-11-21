<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;

class BackpackUser extends CustomModel
{
    use CrudTrait;
//    use HasRoles;

    protected $table = "admin_users";
}
