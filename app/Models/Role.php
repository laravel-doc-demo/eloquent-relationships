<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    // NOTE: 一樣使 belongsToMany 所以上述介紹的用法這邊也可以用。
    // Ex: Role::find(1)->users;
    /**
     * 擁有該 role 的 users
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    //back









    /**
     * 使用 using()
     */
    public function usersEx1(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(RoleUser::class);
    }
}
