<?php

namespace App\Util;

class Divider {
    public $text;

    public function __construct($text){
        $this->text =  $text;
    }

    public function run(){
        $data = $this->trimSpace($this->text);
        $data = $this->divideToBlocks($data);
        $data = $this->divideToLines($data);
        dd($data);
        // return $lines;
    }

    //全角と半角スペースを削除する
    private function trimSpace($text){
        return preg_replace("/( |　|\n)/", "", $text);
    }

    private function divideToBlocks(string $text):array{
        return explode('┏',$text);
    }

    private function divideToLines(array $blocks):array{
        $ret = [];
        foreach($blocks as  $i => $block){
            $rows =  explode('┨',$block);
            foreach($rows as $j => $row){
                $lines = explode('┃',$row);
                foreach($lines as $k => $line){
                    $ret[$i][$j][$k] = explode('│',$line);
                }
                // $ret[$i][$j] = array_map('current', array_chunk(array_slice($lines, 1), 2));
                // $ret[$i][$j] = explode('┃',$row);
            }
        }
        return $ret;
    }

    // private function divideToLines($rows):array{
    //     $ret = [];
    //     foreach($blocks as  $i => $block){
    //         $ret[$i] = explode('┃',$block);
    //         // $ret[$i] = array_map('current', array_chunk(array_slice($lines, 1), 2));
    //         //https://qiita.com/mpyw/items/925e4587a746d8ede8fc
    //     }
    //     return $ret;
    // }

    // public function test($text){
    //     $text = $this->trimSpace($text);
    //     $pieces = $this->multiExplode($text);
    //     $pieces = $this->removeEmptyString($pieces);
    //     return $pieces;
    // }

    // // ┃と│で分割
    // private function multiExplode($text){
    //     $pattern = '/┃|│/u';
    //     $pieces =  preg_split($pattern ,$text);
    //     return $pieces;
    // }

    // //空文字の要素を削除する
    // private function removeEmptyString($pieces){
    //     $pieces = collect($pieces)
    //     ->filter(function ($value, $key) {
    //         return !is_string($value) || strlen($value);
    //     });
    //     return $pieces->all();
    // }

    // private function explodeByPragraph($chara){
    //     //表が3つあるのでまずはそれで分割する？
    // }
}
