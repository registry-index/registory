<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Util\Divider;
use \Spatie\PdfToText\Pdf;
use App\Models\Property;
use App\Models\Owner;

class FileController extends Controller{

    //todo ファイルサイズは2Mを超えるとエラーが起きるはずなのでエラーを出す(PostTooLargeException)


    const PDF_EXTENSION =  '.pdf';

    public function form(){
        return view('files.form');
    }

    public function upload(Request $request)
    {
        $unixTime = time();
        $fileName = $unixTime.self::PDF_EXTENSION;

        //todo ここら辺はtry,catchでエラーハンドリングする
        $request->file->storeAs('pdfs',$fileName);

        $path = storage_path() . '/app/pdfs/' . $fileName;
        $text = Pdf::getText($path,null);
        //todo 必要であれあばS3にアップロード + localのは削除

        $divider = new Divider($text);
        $property = Property::storeFromFileData($divider->getHead());
        Owner::storeFromFileData($divider->getOwners(),$property);

        return redirect('/');
    }
}