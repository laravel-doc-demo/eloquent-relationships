<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    /**
     * 取得 parent model (User 或者 Post)
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
