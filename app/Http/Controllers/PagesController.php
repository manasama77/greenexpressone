<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $pages_privacy = Page::where('id', 1)->first();
        $pages_tnc     = Page::where('id', 2)->first();

        $data = [
            'page_title'     => 'Master Special Area',
            'base_url'       => env('APP_URL'),
            'app_name'       => env('APP_NAME'),
            'app_name_short' => env('APP_NAME_ABBR'),
            'pages_privacy'  => $pages_privacy,
            'pages_tnc'      => $pages_tnc,
        ];
        return view('admin.pages.main')->with($data);
    }

    public function update($id, Request $request)
    {
        $request->validate(
            [
                'page_content' => 'required',
            ]
        );

        $input = $request->all();

        Page::find($id)->update($input);
        return redirect()->route('admin.pages')->with('success', 'Update successfully.');
    }
}
