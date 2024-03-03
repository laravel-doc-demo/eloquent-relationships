<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    // TODO: 一對多

    /**
     * 取得該篇文下的所有留言。
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function commentsEx1(): HasMany
    {
        return $this->hasMany(Comment::class, 'article_id');
    }

    public function commentsEx2(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_uuid', 'uuid');
    }


    // TODO: 預設 model

    /**
     * 取得文章的作者。
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function userEx1(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Author',
        ]);
    }

    public function userEx2(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault(function (User $user, Post $post) {
            $user->name = 'Guest Author (closure)';
        });
    }

    // TODO: whereBelongsTo
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }
}
