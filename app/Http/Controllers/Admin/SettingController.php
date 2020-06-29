<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Url;

use App\Traits\ValidationTrait;

class SettingController extends Controller
{
    use ValidationTrait;
    protected $setting;

    public function __construct(){
        $this->middleware('auth.admin');
        $this->setting = Setting::find(1);
    }

    public function index(Request $request)
    {
        config(['site.page' => 'setting']);
        $setting = $this->setting;
        return view('admin.setting.index', compact('setting'));
    }

    public function save_setting(Request $request)
    {
        $this->setting->update([
            'whatsapp' => $request->whatsapp,
            'telegram' => $request->telegram,
            'mobile' => $request->mobile,
        ]);
        return back()->with('success', __('words.successfully_set'));
    }

    public function withdraw_flag(Request $request) {
        $flag = $request->flag;
        $this->setting->update(['withdraw_flag' => $flag]);
        return response()->json('success');
    }

    public function deposit_flag(Request $request) {
        $flag = $request->flag;
        $this->setting->update(['deposit_flag' => $flag]);
        return response()->json('success');
    }   

    public function transfer_flag(Request $request)
    {
        $flag = $request->flag;
        $this->setting->update(['transfer_flag' => $flag]);
        return response()->json('success');
    }

    public function get_url() {
        config(['site.page' => 'url']);
        $data = Url::all();
        return view('admin.setting.url', compact('data'));
    }

    public function create_url(Request $request)
    {

        $validator = $this->verify($request, 'admin.create_url');
        if ($validator->fails()) {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        $url = new Url($request->except('_token', 'id'));
        $url->save();
        config(['site.page' => 'url']);
        return responseSuccess(__('words.created_successfully'));
    }

    public function update_url(Request $request)
    {
        $validator = $this->verify($request, 'admin.update_url');
        if ($validator->fails()) {
            $messages = $validator->messages()->toArray();
            return responseWrong($messages);
        }

        $url = Url::where('id', '=', $request->id)->update($request->except('_token', 'id'));
        config(['site.page' => 'url']);
        return responseSuccess(__('words.updated_successfully'));
    }

    public function delete_url($id) {
        $url = Url::where('id', '=', $id)->delete();
        return back()->with("success", __('words.deleted_successfully'));
    }
}
