<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterArea extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'area_type',
        'is_active',
    ];

    protected $hidden = [
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function master_sub_area()
    {
        return $this->hasMany(MasterSubArea::class);
    }
}
