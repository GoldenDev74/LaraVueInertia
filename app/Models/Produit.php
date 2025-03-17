<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\Hasfactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use Hasfactory;

    protected $table = 'produits';
    protected $fillable = [
        'name',
        'prix_unitaire',
    ];
}
