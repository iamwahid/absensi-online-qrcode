<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.index');
    }

    public function rating(Request $request)
    {
        if (strtolower($request->method()) == 'post') {
            $user = auth()->user();
            if (!$user->rating) {
                $rating = $user->rating()->create($request->except('_token'));
            } else {
                $user->rating()->update($request->except('_token'));
            }
    
            return redirect()->route('frontend.rating.form');
        }

        return view('frontend.rating');
    }
}
