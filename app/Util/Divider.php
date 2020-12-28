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
        $lines = preg_split($pattern, $tableString, -1, PREG_SPLIT_NO_EMPTY);
        //テーブルのヘッダー部分を削除
        array_shift($lines);
        array_shift($lines);

        $ret = [];
        foreach($lines as $i => $line){
            //行頭と行末の┃を削除
            $line = preg_replace('/^┃+|┃$/','',$line);
            $cells = explode("┃┃",$line);

            $tmp = [];
            foreach($cells as $cell){
                $data = explode("│",$cell);
                $tmp[] = $data;
            }

            //セルが複数行にまたぐこともあるため文字列を結合する
            $cells = [];
            foreach($tmp as $key => $row){
                if($key === 0){
                    $cells = $tmp[0];
                }else{
                    foreach($row as $n=>$mas)
                    $cells[$n] = $cells[$n] . $mas;
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
