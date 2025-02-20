<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function store(Request $request)
    {
        // Debug log
        \Log::info('Received request:', $request->all());
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request path: ' . $request->path());

        try {
            $validated = $request->validate([
                'nik' => 'required|string|size:16',
                'nama' => 'required|string|max:255',
                'no_hp' => 'required|string|max:15',
                'email' => 'required|email|max:255',
                'alamat' => 'required|string',
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'bukti_file' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048'
            ]);

            $token = Str::random(32);
            
            // Handle file upload
            if ($request->hasFile('bukti_file')) {
                $file = $request->file('bukti_file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/bukti', $fileName);
            } else {
                throw new \Exception('File tidak ditemukan');
            }

            $pengaduan = Pengaduan::create([
                'nik' => $validated['nik'],
                'nama' => $validated['nama'],
                'no_hp' => $validated['no_hp'],
                'email' => $validated['email'],
                'alamat' => $validated['alamat'],
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'bukti_file' => $fileName,
                'status' => 'pending',
                'token' => $token
            ]);

            return response()->json([
                'message' => 'Pengaduan berhasil dikirim',
                'token' => $token
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', $e->errors());
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error in PengaduanController@store: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat memproses pengaduan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function publicTimeline()
    {
        try {
            $pengaduan = Pengaduan::with(['tanggapan' => function($query) {
                $query->latest();
            }])
            ->where('status', 'approved')
            ->latest()
            ->get()
            ->map(function ($item) {
                // Hide personal information
                $item->nama = 'Anonymous';
                $item->nik = '****************';
                $item->no_hp = '**********';
                $item->email = '****@****.com';
                $item->alamat = 'Alamat disamarkan';
                return $item;
            });

            return response()->json($pengaduan);
        } catch (\Exception $e) {
            \Log::error('Error in PengaduanController@publicTimeline: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat memuat data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function checkStatus($token)
    {
        try {
            $pengaduan = Pengaduan::with('tanggapan')
                ->where('token', $token)
                ->first();

            if (!$pengaduan) {
                return response()->json([
                    'message' => 'Pengaduan tidak ditemukan'
                ], 404);
            }

            return response()->json($pengaduan);
        } catch (\Exception $e) {
            \Log::error('Error in PengaduanController@checkStatus: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat mencari pengaduan'
            ], 500);
        }
    }

    public function adminIndex()
    {
        try {
            $pengaduan = Pengaduan::with('tanggapan')->latest()->get();
            
            $stats = [
                'pending' => Pengaduan::where('status', 'pending')->count(),
                'processing' => Pengaduan::where('status', 'processing')->count(),
                'approved' => Pengaduan::where('status', 'approved')->count(),
                'rejected' => Pengaduan::where('status', 'rejected')->count(),
            ];

            return response()->json([
                'pengaduan' => $pengaduan,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in PengaduanController@adminIndex: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat memuat data'
            ], 500);
        }
    }

    public function respond(Request $request, Pengaduan $pengaduan)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:approved,rejected',
                'tanggapan' => 'required|string'
            ]);

            $pengaduan->update(['status' => $validated['status']]);

            $pengaduan->tanggapan()->create([
                'user_id' => auth()->id(),
                'isi' => $validated['tanggapan']
            ]);

            return response()->json([
                'message' => 'Tanggapan berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in PengaduanController@respond: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan tanggapan'
            ], 500);
        }
    }
} 