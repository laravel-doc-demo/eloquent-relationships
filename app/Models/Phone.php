<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Phone extends Model
{
    use HasFactory;

    /**
     * 取得有此電話的 user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userEx1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function userEx2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }
}
