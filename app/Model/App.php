<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $table = 'app';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_name',
        'app_icon',
        'app_desc',
        'app_site',
        'cb_uri',
        'test_cb_uri',
    ];
}
