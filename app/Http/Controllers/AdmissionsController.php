<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admission;
use Illuminate\Support\Facades\File;

class AdmissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admissions = new Admission;
        $admissions = $admissions->paginate(4);
        return view('school.admin.Admission.index', compact('admissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $admissions = new Admission;
        // return view('school.admin.Admission.create', compact('admissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'studentID'   => 'required|exists:students,id',
            'courseID'    => 'required|exists:courses,id',
            'name'        => 'required|string|max:255',
            'courseName'  => 'required|string|max:255',
            'img'         => 'required|image|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('img')) {
            $fileName = $validated['studentID'] . '-' . time() . '.' . $request->img->extension();
            $request->img->move(public_path('formimg'), $fileName);
            $validated['img'] = $fileName;
        }

        Admission::create($validated);

        return redirect('booked');
    }

    /**
     * Display the specified resource.
     * @param   App\Models\admissions  $admissions
     * @param  int  $admissionID
     * @return \Illuminate\Http\Response
     */
    public function show($admissionID)
    {
        $admissions = new Admission;
        $admissions = $admissions->where('admissionID', $admissionID)->First();
        return view('school.admin.Admission.show', compact('admissions'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param   App\Models\admissions  $admissions
     * @param  int  $admissionID
     * @return \Illuminate\Http\Response
     */
    public function edit($admissionID)
    {
        $admissions = new Admission;
        $admissions = $admissions->where('admissionID', $admissionID)->First();
        return view('school.admin.Admission.edit', compact('admissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $admissionID
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $admissionID)
    {
        $admission = Admission::where('admissionID', $admissionID)->firstOrFail();

        // Handle image upload
        if ($request->hasFile('img')) {
            $fileName = $request->course_code . '-' . time() . '.' . $request->img->extension();

            // Delete old image if exists
            if ($admission->img && File::exists(public_path('uploads/' . $admission->img))) {
                File::delete(public_path('uploads/' . $admission->img));
            }

            $request->img->move(public_path('uploads'), $fileName);
            $admission->img = $fileName;
        }

        // Mass assign safe fields
        $admission->fill([
            'studentID'   => $request->studentID,
            'courseID'    => $request->courseID,
            'name'        => $request->name,
            'courseName'  => $request->courseName,
        ]);

        $admission->save();

        return redirect('admin/admission');
    }
    /**
     * Remove the specified resource from storage.
     * @param   App\Models\admissions  $admissions
     * @param  int  $admissionID
     * @return \Illuminate\Http\Response
     */
    public function destroy($admissionID)
    {
        $admissions = new Admission;
        $admissions = $admissions->where('admissionID', $admissionID);
        File::delete(public_path('uploads/' . $admissions->img));
        $admissions->delete();
        return redirect('admin/admission')->with('message', 'Your data has been deleted');
    }
}
