<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;

class FrontendController extends Controller
{
    public function demoImportFilesms()
    {
        $path = filePath()['demo']['path'].'/demo_import.xlsx';
        $title = 'demo_import_file.xlsx';
        $headers = [
            'Content-Type'              => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Length'            => filesize($path),
            'Cache-Control'             => 'must-revalidate',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Disposition'       => 'attachment; filename='.$title
        ];
        return response()->download($path, 'demo_sms_import.xlsx', $headers);
    }

    public function demoImportFile()
    {
        $path = filePath()['demo']['path_email'].'/demo_import.xlsx';
        $title = 'demo_import_file.xlsx';
        $headers = [
            'Content-Type'              => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Length'            => filesize($path),
            'Cache-Control'             => 'must-revalidate',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Disposition'       => 'attachment; filename='.$title
        ];
        return response()->download($path, 'demo_email_import.xlsx', $headers);
    }

    public function demoFileDownlode($extension)
    {
        $path = filePath()['demo']['path'].'/demo.'.$extension;
        $title = slug('file').'-'.'/demo.'.$extension;
        if ($extension =='xlsx') {
            $headers = [
                'Content-Type'              => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Length'            => filesize($path),
                'Cache-Control'             => 'must-revalidate',
                'Content-Transfer-Encoding' => 'binary',
                'Content-Disposition'       => 'attachment; filename='.$title
            ];
            return response()->download($path, 'demo.xlsx', $headers);
        }
        if ($extension=='csv'){
            return response()->download($path, 'demo.csv', ['Content-Description' =>  'File Transfer','Content-Type' => 'application/octet-stream','Content-Disposition' => 'attachment; filename=demo.csv']);
        }
        else{
            return response()->download($path, 'demo.txt', ['Content-Description' =>  'File Transfer','Content-Type' => 'application/octet-stream','Content-Disposition' => 'attachment; filename=demo.txt']);
        }

    }


    public function demoEmailFileDownlode($extension)
    {

        $path = filePath()['demo']['path_email'].'/demo.'.$extension;
        $title = slug('file').'-'.'/demo.'.$extension;
        if ($extension=='xlsx') {
            $headers = [
                'Content-Type'              => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Length'            => filesize($path),
                'Cache-Control'             => 'must-revalidate',
                'Content-Transfer-Encoding' => 'binary',
                'Content-Disposition'       => 'attachment; filename='.$title
            ];
            return response()->download($path, 'demo.xlsx', $headers);
        }
        if ($extension=='csv'){
            return response()->download($path, 'demo.csv', ['Content-Description' =>  'File Transfer','Content-Type' => 'application/octet-stream','Content-Disposition' => 'attachment; filename=demo.csv']);
        }

    }

    public function defaultImageCreate($size=null)
    {
        $width = explode('x',$size)[0];
        $height = explode('x',$size)[1];
        $image = imagecreate($width, $height);
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        if($width > 100 && $height > 100){
            $fontSize = 30;
        }else{
            $fontSize = 5;
        }
        $text = $width . 'X' . $height;
        $backgroundcolor = imagecolorallocate($image, 237, 241, 250);
        $textcolor    = imagecolorallocate($image, 107, 111, 130);
        imagefill($image, 0, 0, $textcolor);
        $textsize = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textsize[4] - $textsize[0]);
        $textHeight = abs($textsize[5] - $textsize[1]);
        $xx = ($width - $textWidth) / 2;
        $yy = ($height + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $xx, $yy, $backgroundcolor , $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }


    public function languageChange($id = null)
    {
        $language = Language::where('id', $id)->first();
        if(!$language){
            $lang = 'en';
            $flag = 'us';
        }

        session()->put('flag', $language->flag);
        session()->put('lang', $language->code);
        $notify[] = ['success', 'Language set to '.$language->name];
        return back()->withNotify($notify);
    }
}
