<?php

namespace App\Util;

class Divider {
    public $text;

    public function __construct($text){
        $this->text = $text;
    }

    /**
     * ヘッド部分（表の外側）を取得する
     */
    public function getHead() :array
    {
        //┏が出現するまでの文字列
        $headString = strstr($this->text, '┏' , true);
        $headArr = explode("\n",$headString);

        $ret = [];
        if(count($headArr) === 9){
            $ret['date'] = $headArr[0];
            $ret['time'] = $headArr[2];
            $ret['address'] = $headArr[6];
            $ret['type'] = $this->getPropertyType($headArr[7]);
        }else{
            //エラーをはく。ヘッド部分の書式が異なります。
        }
        return $ret;
    }

    /**
     * 物件タイプを取得する
     */
    private function getPropertyType(string $str):string
    {
        $startNum = mb_strpos($str,'（') + 1;
        $endNum = mb_strpos($str,'）');
        $length = $endNum - $startNum;
        return mb_substr($str, $startNum, $length);
    }

    /**
     * 所有者の情報を取得する
     */
    public function getOwners()
    {
        $tableString =  strstr($this->trimSpace($this->text), '┏');
        $pattern = "/[┠┏┗].+?[┓┨┛]/u";
        $rows = preg_split($pattern, $tableString, -1, PREG_SPLIT_NO_EMPTY);
        //テーブルのヘッダー部分を削除
        array_shift($rows);
        array_shift($rows);

        $ret = [];
        foreach($rows as $i => $row){
            //行頭と行末の┃を削除
            $row = preg_replace('/^┃+|┃$/','',$row);
            $lines = explode("┃┃",$row);

            $cells = [];
            foreach($lines as $j => $line){
                $atoms = explode("│",$line);
                //1行目はそのまま代入する。2行目からは文字列を結合する。
                if($j === 0){
                    $cells = $atoms;
                }else{
                    foreach($atoms as $k => $atom)
                    $cells[$k] = $cells[$k] . $atom;
                }
            }
            $ret[$i] =  $cells;
        }
        return $ret;
    }

    /**
     * スペース、改行、改ページを削除する
     */
    private function trimSpace($text)
    {
        return preg_replace("/( |　|\n|\f)/", "", $text);
    }
}
