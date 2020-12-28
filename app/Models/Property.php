<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Property extends Model
{
    protected $fillable = ['id','user_id','address','type'];

    public function owners()
    {
        return $this->hasMany('App\Models\Owner');
    }

    public static function storeFromFileData($head)
    {
        $propertyData = [
            'user_id' => Auth::user()->id,
            'address' => $head['address'],
            'type' => $head['type'],
        ];
        return Property::create($propertyData);
    }


}