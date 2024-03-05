<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
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






    // NOTE: 一對一
    // NOTE: hasOne 第一個參數是關聯的 model，然後就可以以屬性的方式得到 phone。
    // EX: User::find(2)->phone;

    /**
     * 取得 user 的電話
     *
     * @return HasOne
     */
    public function phone(): HasOne
    {
        return $this->hasOne(Phone::class);
    }

    // NOTE: 該方法會預設關聯的外鍵是 user_id 並且會主動假設該外鍵與主鍵關聯 users.id，與，如果想自己定義可以傳遞第二參數以及第三參數。
    // EX: User::find(2)->phoneEx1;
    public function phoneEx1(): HasOne
    {
        return $this->hasOne(Phone::class, 'member_id');
    }

    // EX: User::find(2)->phoneEx2;
    public function phoneEx2(): HasOne
    {
        return $this->hasOne(Phone::class, 'user_uuid', 'uuid');
    }
    // back








    // NOTE: Has One of Many
    // NOTE: 取得最新最舊的訂單
    // Ex: User::find(1)->latestOrder;
    /**
     * 取得 user 最新的訂單。
     */
    public function latestOrder(): HasOne
    {
        return $this->hasOne(Order::class)->latestOfMany();
    }

    // Ex: User::find(1)->oldestOrder;
    /**
     * 取得 user 最舊的訂單。
     */
    public function oldestOrder(): HasOne
    {
        return $this->hasOne(Order::class)->oldestOfMany();
    }

    // NOTE: 使用自訂的方式取得最貴的訂單。
    /**
     * 取得 user 最貴的訂單
     */
    public function largestOrder(): HasOne
    {
        return $this->hasOne(Order::class)->ofMany('price', 'max');
    }
    // back












    // NOTE: 多對多
    // NOTE: 在 belongsToMany() 為了確認中間表名，將會自動按字母順序連結兩個相關的 Model 名稱。 這裡的話就是 role_user
    // NOTE: 關聯關係建立後就可以使用屬性的方式呼嘯 roles 了。
    // Ex: User::find(1)->roles;
    // NOTE: 也可以再取出的資料加以排序處理。
    // EX: User::find(1)->roles()->orderBy('name')->get();
    /**
     * user 所擁有的 role.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    // NOTE: 此處也提供了第二個參數來自訂中間表名。如果實際表名是 user_role 或者 permissions 就可以使用此法綁定。
    public function rolesEx1(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    // NOTE: 同樣的也可以自訂第三第四參數，指定鍵名。
    public function roleEx2(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'role_user',
            'user_id',
            'role_id'
        );
    }
    // back














    // NOTE: 檢索中間列表
    // NOTE: 加上了建立者以及是否啟用
    // EX: User::find(1)->rolesEx3()->first()->pivot;
    public function rolesEx3(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withPivot('active', 'created_by');
    }

    // NOTE: 想要取得時間
    // EX: User::find(1)->rolesEx4()->first()->pivot;
    public function rolesEx4(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function rolesEx5(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->withPivot('active', 'created_by')
            ->withTimestamps();
    }
    // back








    // NOTE: 自訂 pivot 屬性名稱
    // NOTE: 別名成 subscription 來讓中間表更符合語意。
    public function podcasts(): BelongsToMany
    {
        return $this->belongsToMany(Podcast::class)
            ->as('subscription')
            ->withTimestamps();
    }
    // back











    // NOTE: 通過中間表過濾查詢
    // NOTE: 取出以啟用的 user
    // Ex: User::find(1)->rolesEx6;
    public function rolesEx6(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->wherePivot('active', 1)
            ->withPivot('active', 'created_by')
            ->withTimestamps();
    }



     // TODO: 多態 一對一
    /**
     * 取得 user 的 image
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
