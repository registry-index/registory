<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $fillable = ['id','property_id','address','name','equity'];

    public static function storeFromFileData($owners,$property)
    {
        foreach($owners as $owner){
            if(count($owner) === 2){
                $ownerData = [
                    'property_id' => $property->id,
                    'address' => $owner[0],
                    'equity' => '１分の１',
                    'name' => $owner[1],
                ];
            }elseif(count($owner) === 3){
                $ownerData = [
                    'property_id' => $property->id,
                    'address' => $owner[0],
                    'equity' => $owner[1],
                    'name' => $owner[2],
                ];
            }else{
                //todo エラーを出力する
            }
            Owner::create($ownerData);
        }
    }
}