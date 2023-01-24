<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account_Customer extends Authenticatable
{
    use Notifiable;

    protected $table = 'cag_customer_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_firstname','customer_lastname','customer_email', 'customer_password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'customer_password', 'remember_token',
    ];


    public function getAuthPassword()
    {
      return $this->customer_password;
    }
}

?>