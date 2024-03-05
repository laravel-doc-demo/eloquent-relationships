<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    // NOTE: 一對多反向
    // Ex: Comment::find(1)->post->title;
    /**
     * 取得該篇留言的所屬文章。
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    // NOTE: 一樣可以指定鍵
    public function postEx1(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'article_id');
    }

    public function postEx2(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_uuid', 'uuid');
    }
}
