<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nome', 'cognome', 'telefono'
    ];

    /**
     * Get the attributes associated with the Profile.
     */
    public function attributes()
    {
        return $this->hasMany(ProfileAttribute::class);
    }
}
