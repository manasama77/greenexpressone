<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    public function index()
    {
        $pages = Page::get();

        $data = [
            'page_title'     => 'Pages',
            'base_url'       => env('APP_URL'),
            'app_name'       => env('APP_NAME'),
            'app_name_short' => env('APP_NAME_ABBR'),
            'pages'          => $pages,
        ];
        return view('admin.pages.main')->with($data);
    }

    public function add()
    {
        $data = [
            'page_title'     => 'Add New Pages',
            'base_url'       => env('APP_URL'),
            'app_name'       => env('APP_NAME'),
            'app_name_short' => env('APP_NAME_ABBR'),
        ];
        return view('admin.pages.add')->with($data);
    }

    public function store(Request $request)
    {
        $validator  = Validator::make(
            $request->all(),
            [
                'slug'         => 'required|min:3|max:100|unique:pages,slug',
                'page_title'   => 'required|min:3|max:100',
                'page_content' => 'required|min:3',
            ]
        );

        if ($validator->fails()) {
            return redirect('/admin/pages/add')
                ->withErrors($validator)
                ->withInput();
        }

        // $validated = $validator->validated();

        $exec               = new Page();
        $exec->slug         = Str::slug($request->slug, '-');
        $exec->page_title   = $request->page_title;
        $exec->page_content = $request->page_content;
        $exec->save();
        return redirect()->route('admin.pages')->with('success', 'Create successfully.');
    }

    public function edit($id)
    {
        $pages = Page::find($id);
        $data = [
            'page_title'     => 'Edit New Pages',
            'base_url'       => env('APP_URL'),
            'app_name'       => env('APP_NAME'),
            'app_name_short' => env('APP_NAME_ABBR'),
            'pages'          => $pages,
        ];
        return view('admin.pages.edit')->with($data);
    }

    public function update($id, Request $request)
    {
        $request->validate(
            [
                'slug'         => 'required|min:3|max:100|unique:pages,slug,' . $id,
                'page_title'   => 'required|min:3|max:100',
                'page_content' => 'required|min:3',
            ]
        );

        $input = $request->all();
        $input['slug'] = Str::slug($request->slug, '-');

        Page::find($id)->update($input);
        return redirect()->route('admin.pages')->with('success', 'Update successfully.');
    }

    public function delete($id)
    {
        Page::find($id)->delete();
        return response()->json([
            'message' => 'Record deleted successfully!'
        ], 200);
    }
}
