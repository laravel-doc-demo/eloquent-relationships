<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Mechanic extends Model
{
    use HasFactory;

    // NOTE: 遠程一對一
    // NOTE: $related 是最後希望得到的 Model，$through 則是中間 Model
    // Ex: Mechanic::find(1)->carOwner;
    /**
     * 取得車主。
     */
    public function carOwner(): HasOneThrough
    {
        return $this->hasOneThrough(Owner::class, Car::class);
    }

    // NOTE: 也可使用以下兩中方式獲得資料，字串方式或者動態語法。
    public function carOwnerEx1(): HasOneThrough
    {
        return $this->through('cars')->has('owner');
    }

    public function carOwnerEx2(): HasOneThrough
    {
        return $this->throughCars()->hasOwner();
    }

    // NOTE: 如果有需要也可以指定鍵名
    /**
     * Get the car's owner.
     */
    public function carOwnerEx3(): HasOneThrough
    {
        return $this->hasOneThrough(
            Owner::class,
            Car::class,
            'mechanic_id', // Car 的外鍵
            'car_id', // Owner 的外鍵
            'id', // Mechanic 本地鍵
            'id' // Car 本地鍵
        );
    }

    // back
}
