<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Image;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['companies'] = Company::all();
        return view('Employee.index')->with($data);
    }

    public function getEmployees(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                    <div class="d-flex justify-content-center">
                        <a href="' . Route('employees.edit', $row->id) . '" class="edit btn btn-success btn-sm m-1">Edit</a>
                        <form action="' . Route('employees.destroy', $row->id) . '" method="POST">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                    <button type="submit" class="btn btn-danger btn-sm mt-1"
                        onclick="return confirm(\'Are You Sure Want to Delete?\')">Delete</a>
                    </form>
                    </div>';
                    return $actionBtn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function getEmployeesByCompany($id)
    {
        $data['company'] = Company::findOrFail($id);
        return view('Employee.filter')->with($data);
    }


    public function create()
    {
        $data['companies'] = Company::all();
        return view('Employee.create')->with($data);
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
            'email' => 'required|max:100',
            'password' => 'required',
            'company_id' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png'
        ]);

        // Hashing Password before insert into DB
        $data['password'] = Hash::make($request->password);

        // Hashing Image Details And Get Only Its Name
        $new_image_name = $data['image']->hashName();
        // Use Intervention Package To Resize Image And Save It With Its New Name
        // Save image into Storage using Image Intervention Package
        Image::make($data['image'])->resize(400, 300)->save(public_path('/' . $new_image_name));
        $data['image'] = $new_image_name;

        // Send Mail Depend on Event
        Mail::to($data['email'])->send(new WelcomeEmail($data['email']));

        Employee::create($data);
        return redirect()->route('employees.index')->with('success', 'Employee created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['employee'] = Employee::with('company')->findOrFail($id);
        $data['companies'] = Company::select('id', 'name')->get();
        return view('Employee.edit')->with($data);
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
            'email' => 'required|max:100',
            'password' => 'nullable',
            'company_id' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png'
        ]);

        // update password depend on new request or let it with the old value
        $old_password = Employee::findOrFail($id)->password;
        if ($request->has('password')) {
            $new_password = $request->password;
            $data['password'] = Hash::make($new_password);
        } else {
            $data['password'] = $old_password;
        }

        // update password depend on new request or let it with the old value
        $old_name = Employee::findOrFail($id)->image;
        if ($request->hasFile('image')) {
            Storage::disk('uploads')->delete('/' . $old_name);
            $new_image_name = $data['image']->hashName();
            Image::make($data['image'])->resize(400, 300)->save(public_path('/' . $new_image_name));
            $data['image'] = $new_image_name;
        } else {
            $data['image'] = $old_name;
        }

        Employee::findOrFail($id)->update($data);
        return redirect()->route('employees.index')->with('success', 'Employee Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::findOrFail($id)->delete();
        return redirect()->route('employees.index')->with('success', 'Employee Deleted successfully');
    }
}
