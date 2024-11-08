<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'id' => 'gallery',
            'menu' => 'Gallery',
            'galleries' => Gallery::where('picture', '!=', '')
            ->whereNotNull('picture')->orderBy('created_at', 'desc')->paginate(30)
        );
        return view('gallery.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate ($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);
        if ($request->hasFile('picture')) {
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time () ;
            $smallFilename = "small_{$basename}.{$extension}";
            $mediumFilename = "medium_{$basename}.{$extension}";
            $largeFilename = "large_{$basename}.{$extension}";
            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file ('picture') ->storeAs ('posts_image', $filenameSimpan);
        } else {
            $filenameSimpan = 'noimage.png';
        }
        // dd ($request->input());
        $post = new Gallery();
        $post->picture = $filenameSimpan;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->save() ;
        return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = Gallery::findOrFail($id);
        return view('gallery.edit', compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);

        $edit = Gallery::findOrFail($id);
        $edit->title = $request->input('title');
        $edit->description = $request->input('description');

        if ($request->hasFile('picture')) {
            // Delete the old image
            if ($edit->picture && $edit->picture != 'noimage.png') {
                Storage::delete('posts_image/' . $edit->picture);
            }

            // Upload new image
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $filenameSimpan = "{$basename}.{$extension}";
            $request->file('picture')->storeAs('posts_image', $filenameSimpan);
            $edit->picture = $filenameSimpan;
        }

        $edit->save();
        return redirect('gallery')->with('success', 'Gallery updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gallery = Gallery::findOrFail($id);

        if ($gallery->picture && $gallery->picture != 'noimage.png') {
            Storage::delete('posts_image/' . $gallery->picture);
        }

        $gallery->delete();
        return redirect('gallery')->with('success', 'Gallery deleted successfully');
    }
}
