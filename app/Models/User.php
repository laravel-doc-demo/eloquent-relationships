<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
}
