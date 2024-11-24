<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class GalleryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/galleries",
     *     tags={"Galleries"},
     *     summary="Get list of galleries",
     *     description="Returns a paginated list of galleries",
     *     @OA\Response(
     *         response=200,
     *         description="A list of galleries",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="current_page", type="integer"),
     *                 @OA\Property(property="data", type="array",
     *                     @OA\Items(ref="#/components/schemas/Gallery")
     *                 ),
     *                 @OA\Property(property="last_page", type="integer"),
     *                 @OA\Property(property="total", type="integer"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     */
    public function api()
    {
        $galleries = Gallery::where('picture', '!=', '')
            ->whereNotNull('picture')
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return response()->json([
            'status' => 'success',
            'data' => $galleries,
        ], 200);
    }

    public function index()
    {
        // Mengambil data dari API
        $response = Http::get(config('app.url') . '/api/galleries');

        if ($response->successful() && $response->json()['status'] === 'success') {
            $galleries = $response->json()['data']['data']; // Akses data galeri
        } else {
            $galleries = [];
        }

        return view('gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('gallery.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);
        if ($request->hasFile('picture')) {
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $smallFilename = "small_{$basename}.{$extension}";
            $mediumFilename = "medium_{$basename}.{$extension}";
            $largeFilename = "large_{$basename}.{$extension}";
            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
        } else {
            $filenameSimpan = 'noimage.png';
        }
        // dd ($request->input());
        $post = new Gallery();
        $post->picture = $filenameSimpan;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->save();
        return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $edit = Gallery::findOrFail($id);
        return view('gallery.edit', compact('edit'));
    }

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
