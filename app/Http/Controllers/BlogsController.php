<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blogs;
use App\Models\Files;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = new Blogs;
        $blogs = $blogs->paginate(4);
        return view('school.admin.Blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $files = Files::paginate(10);
        return view('school.admin.Blogs.create', compact('files'));
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
            'img'            => 'required|string|max:255',
            'title'          => 'required|string|max:255',
            'introduction'   => 'required|string',
            'type'           => 'required|string|max:100',
            'highlight'      => 'required|string',
            'description'    => 'required|string',
            'description2'   => 'required|string',
            'writerName'     => 'required|string|max:255',
            'post'           => 'required|string',
            'writerView'     => 'required|string',
        ]);
        -Blogs::create($validated);

        return redirect('admin/blog')->with('message', 'Your data is submitted ');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $files = Files::paginate(10);
        $blogs = new Blogs;
        $blogs = $blogs->where('id', $id)->First();
        return view('school.admin.Blogs.show', compact('blogs'), compact('files'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $files = Files::paginate(10);
        $blogs = new Blogs;
        $blogs = $blogs->where('id', $id)->First();
        return view('school.admin.Blogs.edit', compact('blogs', 'files'));
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
        $validated = $request->validate([
            'img'            => 'required|string|max:255',
            'title'          => 'required|string|max:255',
            'introduction'   => 'required|string',
            'type'           => 'required|string|max:100',
            'highlight'      => 'required|string',
            'description'    => 'required|string',
            'description2'   => 'required|string',
            'writerName'     => 'required|string|max:255',
            'post'           => 'required|string',
            'writerView'     => 'required|string',
        ]);

        $blog = Blogs::findOrFail($id);

        $blog->update($validated);
        return redirect('admin/blog');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blogs = new Blogs;
        $blogs = $blogs->where('id', $id)->first();;
        $blogs->delete();
        return redirect('admin/blog')->with('message', 'Your data has been deleted');
    }
}
