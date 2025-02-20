<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class PengaduanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string',
            'nama' => 'required|string',
            'no_hp' => 'required|string',
            'email' => 'required|email',
            'alamat' => 'required|string',
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'bukti_file' => 'required|file|mimes:jpeg,png,pdf|max:2048'
        ]);

        $token = Str::random(32);
        $fileName = time() . '.' . $request->bukti_file->extension();
        $request->bukti_file->storeAs('public/bukti', $fileName);

        $pengaduan = Pengaduan::create([
            ...$validated,
            'bukti_file' => $fileName,
            'status' => 'pending',
            'token' => $token
        ]);

        // Send email to user
        Mail::to($request->email)->send(new PengaduanCreated($pengaduan));

        return response()->json([
            'message' => 'Pengaduan berhasil dikirim',
            'token' => $token
        ]);
    }
} 