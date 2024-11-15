<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> Attributes that can be set via mass assignment.
     */
    protected $fillable = ['name', 'description'];

    /**
     * Define the relationship with the Service model.
     *
     * A ServiceCategory can have many associated Service records.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
