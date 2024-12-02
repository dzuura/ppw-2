<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendEmailJob;
use App\Mail\SendEmail;
use Mail;
use App\Models\User;

class SendEmailController extends Controller
{
    public function index()
    {
        return view('emails.sendEmail');
    }

    public function registerEmail()
    {
        return view('emails.registerEmail');
    }

    public function store(Request $request)
    {
        $subject = 'Akun Berhasil Didaftarkan';
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $subject,
            'created_at' => now()
        ];

        if ($request->hasFile('photo')) {
            $filenamewithext = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenamewithext, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenamesimpan = $filename . '_' . time() . '_' . $extension;
            $path = $request->file('photo')->storeAs('photos', $filenamesimpan);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'photo' => $path
        ]);

        dispatch(new SendEmailJob($data));

        return redirect()->route('gallery.index')->with('success', 'Email Berhasil dikirim!');
    }
}
