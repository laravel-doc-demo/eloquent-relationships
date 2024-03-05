<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Project extends Model
{
    use HasFactory;

    // NOTE: 遠程一對多
    // Ex: Project::find(1)->deployments;
    /**
     * 取得所有 deployments
     */
    public function deployments(): HasManyThrough
    {
        return $this->hasManyThrough(Deployment::class, Environment::class);
    }

    // NOTE: 跟 hasManyThrough  一樣可以使用字串以及動態語法，以及依照需求自己指定鍵名稱
    public function deploymentsEx1(): HasManyThrough
    {
        return $this->through('environments')->has('deployments');
    }

    public function deploymentsEx2(): HasManyThrough
    {
        return $this->throughEnvironments()->hasDeployments();
    }
    //back
}
