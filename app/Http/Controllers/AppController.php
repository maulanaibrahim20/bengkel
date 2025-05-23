<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function home(Request $request)
    {
        $data = [
            'services' => Service::with('detail')->get(),
            'products' => Product::latest()->where('status', 'active')->take(3)->get()
        ];
        return view('landing.pages.home.index', $data);
    }

    public function about(Request $request)
    {
        return view('landing.pages.about.index');
    }

    public function service(Request $request)
    {
        return view('landing.pages.service.index');
    }

    public function booking(Request $request)
    {
        return view('landing.pages.booking.index');
    }

    public function bookingRegister()
    {
        return view('landing.pages.booking.book_register');
    }

    public function contact(Request $request)
    {
        return view('landing.pages.contact.index');
    }
}
