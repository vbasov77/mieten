<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    public function add(Request $request)
    {

        if ($request->file('file')) {
            $file = $request->file('file');
            $filename = self::getFileName($file);
            $request->session()->push('images', $filename);
            $request->session()->save();
            $images = (string)implode(',', session('images'));
            $result = ['answer' => 'ok', 'fil' => $images];
            exit(json_encode($result));
        }
    }

    public function delSession(Request $request)
    {
        $images = session('images');
        if (!empty(count($images))) {
            for ($i = 0; $i < count($images); $i++) {
                File::delete(public_path('images/' . $images[$i]));
            }
        }
        $request->session()->forget('images');
        $request->session()->save();
    }

    function uploadDrop(Request $request)
    {
        if ($request->file('file')) {
            $file = $request->file('file');
            $filename = self::getFileName($file);
            Image::insert([
                'obj_id' => $request->id,
                'path' => $filename,

            ]);
            $result = Image::where('obj_id', $request->id)->get();
            foreach ($result as $value) {
                $array[] = $value->path;
            }
            $data = implode(',', $array);
            $fil = (string)$data;
            $res = ['answer' => 'ok', 'fil' => $fil];
        } else {
            $res = ['answer' => 'error', 'mess' => 'Ошибка'];
        }
        exit(json_encode($res));
    }

    public function deleteDrop(Request $request)
    {
        if ($request->get('file')) {
            File::delete(public_path('images/' . $request->get('file')));
            $file = $request->get('file');
            Image::where('path', $file)->delete();
        }
    }



    public static function getFileName($file)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $filename = substr(str_shuffle($permitted_chars), 0, 16) . '.' . $file->extension();
        $file->move(public_path('images'), $filename);
        return $filename;
    }
}
