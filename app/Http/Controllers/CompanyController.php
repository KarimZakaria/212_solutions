<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Image;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Company.index');
    }

    public function getCompanies(Request $request)
    {
        if ($request->ajax()) {
            $data = Company::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                    <div class="d-flex justify-content-center">
                        <a href="' . Route('companies.edit', $row->id) . '" class="edit btn btn-success btn-sm ml-1 mr-1">Edit</a>
                        <form action="' . Route('companies.destroy', $row->id) . '" method="POST">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm(\'Are You Sure Want to Delete?\')">Delete</a>
                    </form>
                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('Company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:50|min:5',
            'adress' => 'required|max:100',
            'logo' => 'required|mimes:jpg,jpeg,png'
        ]);
        // Hashing Image Details And Get Only Its Name
        $new_image_name = $data['logo']->hashName();
        // Use Intervention Package To Resize Image And Save It With Its New Name
        // Save image into Storage using Image Intervention Package
        Image::make($data['logo'])->resize(400, 300)->save(public_path('/' . $new_image_name));
        $data['logo'] = $new_image_name;

        Company::create($data);
        return redirect()->route('companies.index')->with('success', 'Company created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['company'] = Company::findOrFail($id);
        return view('Company.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|max:50|min:5',
            'adress' => 'required|max:100',
            'logo' => 'nullable|mimes:jpg,jpeg,png'
        ]);

        $old_name = Company::findOrFail($id)->logo;
        if ($request->hasFile('logo')) {
            Storage::disk('uploads')->delete('/' . $old_name);
            $new_image_name = $data['logo']->hashName();
            Image::make($data['logo'])->resize(400, 300)->save(public_path('/' . $new_image_name));
            $data['logo'] = $new_image_name;
        } else {
            $data['logo'] = $old_name;
        }

        Company::findOrFail($id)->update($data);
        return redirect()->route('companies.index')->with('success', 'Company Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Company::findOrFail($id)->delete();
        return redirect()->route('companies.index')->with('success', 'Company Deleted successfully');
    }
}
