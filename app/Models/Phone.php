<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Phone extends Model
{
    use HasFactory;

    // NOTE: 一對一反向
    // NOTE: 上述是可以從 User model 訪問 Phone，以下是方法可以使 Phone 反向取的得關聯的 User，該方法與 hasOne 對應。
    // EX:Phone::find(2)->user;
    /**
     * 取得有此電話的 user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // NOTE: 除此之外和 hasOne 一樣可以使用第二第三參數來指定鍵。
    // EX: Phone::find(2)->userEx1;
    public function userEx1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    // EX: Phone::find(2)->userEx2;
    public function userEx2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }
}
