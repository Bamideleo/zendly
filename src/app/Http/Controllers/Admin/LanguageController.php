<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class LanguageController extends Controller
{

    public function index()
    {
        $title = "Manage language";
        $languages = Language::latest()->get();
        $countries = json_decode(file_get_contents(resource_path('views/partials/country_file.json')));
        return view('admin.language.index', compact('title', 'languages','countries'));
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'flag' => 'required|max:255|unique:languages,flag,'.$request->id,
            'name' => 'required|max:255|unique:languages,name,'.$request->id,
            'code' => 'required|max:255|unique:languages,code'.$request->id,
        ]);
        $json_data = file_get_contents(resource_path('lang/') . 'en.json');
        $file = strtolower($request->code) . '.json';
        $path = resource_path('lang/') . $file;
        File::put($path, $json_data);
        Language::create([
            'flag' => Str::lower($request->flag),
            'name' => $request->name,
            'code' => strtolower($request->code),
            'is_default' => 0
        ]);
        $notify[] = ['success', 'Language has been created'];
        return back()->withNotify($notify);
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:255|unique:languages,name,'.$request->id
        ]);
        $language = Language::findOrFail($request->id);
        $language->update([
            'name' => $request->name
        ]);
        $notify[] = ['success', 'Language has been updated'];
        return back()->withNotify($notify);
    }

    public function setDefaultLang(Request $request)
    {
        $this->validate($request,[
            'id' => 'required'
        ]);
        Language::where('is_default', 1)->update([
            'is_default' => 0
        ]);

        $language = Language::findOrFail($request->id);

        $language->update([
            'is_default' => 1
        ]);
        session()->put('flag', $language->flag);
        session()->put('lang', $language->code);
        $notify[] = ['success', 'Default language has been set to '.$language->name];
        return back()->withNotify($notify);
    }


    public function translate($code)
    {
        $language = Language::where('code',$code)->first();
        $title = "Language update " . $language->name . " Keywords";
        $data = file_get_contents(resource_path('lang/') . $language->code . '.json');
        $languages = Language::get();
        if (empty($data)) {
            $notify[] = ['error', 'This language File not found'];
            return back()->withNotify($notify);
        }
        $datas = json_decode($data);
        return view('admin.language.edit', compact('title', 'datas', 'language', 'languages'));
    }


    public function languageDataStore(Request $request)
    {
        $this->validate($request, [
            'key' => 'required',
            'value' => 'required'
        ]);
        $language = Language::findOrFail($request->id);
        $key = trim($request->key);
        $data = file_get_contents(resource_path('lang/') . $language->code . '.json');
        if(array_key_exists($key, json_decode($data, true))) {
            $notify[] = ['error', "$key Already exist"];
            return back()->withNotify($notify);
        }else {
            $array[$key] = trim($request->value);
            $datas = json_decode($data, true);
            $arrayMerge = array_merge($datas, $array);
            file_put_contents(resource_path('lang/') . $language->code . '.json', json_encode($arrayMerge));
            $notify[] = ['success', $key." has been added"];
            return back()->withNotify($notify);
        }
    }

    public function languageDataUpdate(Request $request)
    {
        $data = file_get_contents(resource_path('lang/') . $request->data['code'] . '.json');
        $datas = json_decode($data, true);
        $datas[$request->data['key']] = trim($request->data['keyValue']);
        file_put_contents(resource_path('lang/'). $request->data['code'] . '.json', json_encode($datas));
        return json_encode([
            'status' => 200,
            'message' =>'Language key has been updated'
        ]);
    }

    public function languageDelete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $language = Language::findOrFail($request->id);
        if ($language->is_default == 1) {
            $notify[] = ['error', "You can not remove default language"];
            return back()->withNotify($notify);
        }

        $langfile = resource_path('lang/') . $language->code . '.json';
        unlink($langfile);
        $notify[] = ['success', "Language Data Removed"];
        $language->delete();
        $notify[] = ['success', "Language Removed"];
        return back()->withNotify($notify);
    }

    public function languageDataUpDelete(Request $request)
    {
        $this->validate($request, [
            'key' => 'required'
        ]);
        $language = Language::findOrFail($request->id);
        $key = trim($request->key);
        $data = file_get_contents(resource_path('lang/') . $language->code . '.json');
        $datas = json_decode($data, true);
        unset($datas[$key]);
        file_put_contents(resource_path('lang/'). $language->code . '.json', json_encode($datas));
        $notify[] = ['success', trim($key)." has been removed"];
        return back()->withNotify($notify);
    }
}
