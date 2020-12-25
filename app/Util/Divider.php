<?php

namespace App\Util;

class Divider {
    public $text;

    public function __construct($text){
        $this->text =  $text;
    }

    public function run(){
        $title = $this->getTitle($this->text);
        $table = $this->getTable($this->text);
        dd($title,$table);
    }

    /**
     * タイトル部分（表の外側）を取得する
     */
    private function getTitle($data) :array
    {
        $table = strstr($data, '┏' , true);
        $arr = explode("\n",$table);

        if(count($arr) === 9){
            $ret['date'] = $arr[0];
            $ret['time'] = $arr[2];
            $ret['address'] = $arr[6];
            $ret['type'] = $this->getPropertyType($arr[7]);
        }else{
            //エラーをはく。タイトル部分の書式が異なります。
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
     * テーブルの情報を取得する
     */
    private function getTable($data){
        $table =  strstr($this->trimSpace($data), '┏');
        $pattern = "/[┠┏┗].+?[┓┨┛]/u";
        $lines = preg_split($pattern,$table,-1,PREG_SPLIT_NO_EMPTY);
        $ret = [];
        foreach($lines as $i => $line){
            $line = trim($line, '┃');
            $line = rtrim($line, '┃');
            $cells = explode("┃┃",$line);

            $tmp = [];
            foreach($cells as $j => $cell){
                $data = explode("│",$cell);
                $tmp[] = $data;
            }

            // dump($tmp);
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
    private function trimSpace($text){
        return preg_replace("/( |　|\n|\f)/", "", $text);
    }
}
