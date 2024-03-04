<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /*
     * 一對一
     * 在兩個 table 中
     * 一張表的 record 在另張表的的中僅有一筆關聯 record。
     */


    /**
     * 取得 user 的電話
     *
     * hasOne 第一個參數是關聯的 model，然後就可以以屬性的方式得到 phone。
     *
     * @return HasOne
     */
    public function phone(): HasOne
    {
        return $this->hasOne(Phone::class);
    }

    /**
     *
     * @return HasOne
     */
    public function phoneEx1(): HasOne
    {
        // return $this->hasOne(Phone::class, 'foreign_key');
        return $this->hasOne(Phone::class, 'member_id');
    }

    /**
     * @return HasOne
     */
    public function phoneEx2(): HasOne
    {
        // return $this->hasOne(Phone::class, 'foreign_key', 'local_key');
        return $this->hasOne(Phone::class, 'user_uuid', 'uuid');
    }

    // TODO: Has One of Many

    /**
     * 取得 user 最新的訂單。
     */
    public function latestOrder(): HasOne
    {
        return $this->hasOne(Order::class)->latestOfMany();
    }

    /**
     * 取得 user 最舊的訂單。
     */
    public function oldestOrder(): HasOne
    {
        return $this->hasOne(Order::class)->oldestOfMany();
    }

    /**
     * 取得 user 最貴的訂單
     */
    public function largestOrder(): HasOne
    {
        return $this->hasOne(Order::class)->ofMany('price', 'max');
    }

    // TODO: Many to Many

    /**
     * user 所擁有的 role.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function rolesEx1(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withPivot('active', 'created_by');
    }

    public function rolesEx2(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function rolesEx3(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->withPivot('active', 'created_by')
            ->withTimestamps();
    }

    public function rolesEx4(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->wherePivot('active', 1)
            ->withPivot('active', 'created_by')
            ->withTimestamps();
    }



    public function podcasts(): BelongsToMany
    {
        return $this->belongsToMany(Podcast::class)
            ->as('subscription')
            ->withTimestamps();
    }
}
