<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    public function setLang($locale)
    {
        if (!in_array($locale, ['en', 'cn', 'tw', 'th', 'id', 'vn'])) {
            abort(400);
        }

        App::setlocale($locale);
        Session::put("locale", $locale);
        return back();
    }
}
