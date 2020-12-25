<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Util\Divider;
use \Spatie\PdfToText\Pdf;

class FileController extends Controller{

    const PDF_EXTENSION =  '.pdf';

    public function form(){
        return view('file.form');
    }

    public function upload(Request $request)
    {
        $unixTime = time();
        $fileName = $unixTime.self::PDF_EXTENSION;
        $request->file->storeAs('pdfs',$fileName);

        return null;
    }

    public function read(){
        // for ($i = 1; $i <= 4; $i++) {
            $path = storage_path() . '/app/pdfs/' . "4" . ".pdf";
            $option = [];
            $text = Pdf::getText($path,null,$option);
            $divider = new Divider($text);
            $divider->run();
        // }

    }
}