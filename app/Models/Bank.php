<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Bank extends Model
{
    protected $table = 'tb_bank';

    protected $primaryKey = 'id_bnk';

    protected $fillable = [
        'number_bnk',
        'name_bnk',
        'ein_bnk',
        'contact_bnk',
        'desc_bnk',
        'broker_bnk',
        'img_bnk',
        'primary',
        'secondary',
    ];


    protected $casts = [
        'broker_bnk' => 'boolean',
    ];


    protected $appends = [
        'img_url',
    ];

    
    public function getImgUrlAttribute()
    {
        if (!$this->img_bnk) {
            return null;
        }

        return asset('storage/' . $this->img_bnk);
    }

    /*
    |--------------------------------------------------------------------------
    | Contas do banco
    |--------------------------------------------------------------------------
    */


    public function accounts()
    {
        return $this->hasMany(
            Account::class,
            'fk_bnk',
            'id_bnk'
        );
    }
    
}