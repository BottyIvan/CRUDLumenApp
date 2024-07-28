<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileAttribute extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profile_attributes';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'profile_id', 'attribute'
    ];

    /**
     * Get the Profile that owns the phone.
     */
    public function Profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
