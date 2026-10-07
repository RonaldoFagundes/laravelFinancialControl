<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Account extends Model
{
    
    protected $table = 'tb_account';

    protected $primaryKey = 'id_act';

    public $timestamps = true;

    protected $fillable = [
        'number_act',
        'type_act',
        'desc_act',
        'saldo_act',
        'fk_bnk',
    ];

    protected $casts = [
        'saldo_act' => 'float',
        'fk_bnk' => 'integer',
    ];


    /*
    |--------------------------------------------------------------------------
    | Relacionamento com banco
    |--------------------------------------------------------------------------
    */

    public function bank()
    {
        return $this->belongsTo(
            Bank::class,
            'fk_bnk',
            'id_bnk'
        );
    }
}
