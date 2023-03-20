<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GlobalWorldController extends Controller
{
    public function index()
    {
        $title = translate('Obsensive Word Block');
        $path = base_path('lang/globalworld/offensive.json');
        if(!file_exists($path)){
            $offensiveData = [];
        }else{
            $offensiveData = json_decode(file_get_contents($path), true);
        }
        return view('admin.global_world.index', compact('title', 'offensiveData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required',
            'value' => 'required',
        ]);
        $path = base_path('lang/globalworld/');
        $fileName = 'offensive.json';
        if(!file_exists($path)){
            mkdir($path, 0777, true);
            $location = $path. $fileName;
            File::put($location ,'{}');
        }
        $offensiveData = json_decode(file_get_contents($path.$fileName), true);
        if(!array_key_exists($request->key, $offensiveData)){
            $offensiveData += [$request->key => $request->value];
            File::put($path.$fileName, json_encode($offensiveData));
            $notify[] = ['success', 'Word Added successfully'];
        } else{
            $notify[] = ['error', 'Word Already Exist'];
        }
        return back()->withNotify($notify);
    }

    public function update(Request $request)
    {
        $request->validate([
            'value' => 'required',
        ]);
        $path = base_path('lang/globalworld/offensive.json');
        $offensiveData = json_decode(file_get_contents($path), true);
        if(array_key_exists($request->key, $offensiveData)){
            $offensiveData[$request->key] = $request->value;
            File::put($path, json_encode($offensiveData));
            $notify[] = ['success', 'Word Updated successfully'];
        } else{
            $notify[] = ['error', 'Word Does not  exist'];
        }
    	return back()->withNotify($notify);
    }

    public function delete(Request $request)
    {
        $path = base_path('lang/globalworld/offensive.json');
        $offensiveData = json_decode(file_get_contents($path), true);
        if(in_array($offensiveData[$request->id], $offensiveData)){
            unset($offensiveData[$request->id]);
            File::put($path, json_encode($offensiveData));
        }
        $notify[] = ['success', 'Word Deleted successfully'];
    	return back()->withNotify($notify);
    }




}
