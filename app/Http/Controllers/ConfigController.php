<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {
        $configs = Config::orderBy('key')->get();

        return view('super-admin.pages.setting.config.index', [
            'configs' => $configs,
            'pageTitle' => 'Content Management System'
        ]);
    }
}
