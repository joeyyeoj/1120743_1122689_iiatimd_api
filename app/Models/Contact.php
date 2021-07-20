<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contactlist';

    protected $fillable = [
        'ownerId', 'contactId'
    ];


    public function myUser(){
        return $this->belongsTo(\App\Models\User::class, "ownerId");
    }

}
