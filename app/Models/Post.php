<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Post extends Model
{
    use HasFactory;

    // NOTE: 一對多
    // NOTE: 外鍵一樣是會自動找到該 model 的名字加上 _id 變成  post_id ，而主鍵就是該 model 的 id
    // EX: Post::find(1)->comments;

    // NOTE: 也可加上限制條件
    // EX: Post::find(3)->comments()->where('title', 'foo')->first();
    /**
     * 取得該篇文下的所有留言。
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // NOTE: 並且與 hasOne 一樣可以自訂 外鍵以及本地鍵
    public function commentsEx1(): HasMany
    {
        return $this->hasMany(Comment::class, 'article_id');
    }

    public function commentsEx2(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_uuid', 'uuid');
    }
    // back







    // NOTE: whereBelongsTo 指定參數
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }
    // back







    // NOTE: 預設 model
    // EX: Post::find(3)->user;
    /**
     * 取得文章的作者。
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    // NOTE: 也可以透過陣列或者閉包的方式給預設屬性。
    // EX: Post::find(3)->userEx1;
    public function userEx1(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Author',
        ]);
    }

    // EX: Post::find(3)->userEx2;
    public function userEx2(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault(function (User $user, Post $post) {
            $user->name = 'Guest Author (closure)';
        });
    }
    // back








    // NOTE: 多態 一對一
    /**
     * 取得 post 的 image.
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    // back
}
