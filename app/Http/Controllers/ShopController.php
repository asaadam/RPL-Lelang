<?php

namespace App\Http\Controllers;

use App\TokoLelang;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    //

    public function createShop(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_toko' => 'required|max:255',
                'no_telepon' => 'required|max:20',
                'nama_jalan' => 'required|max:255',
                'kelurahan' => 'required|max:100',
                'kode_pos' => 'required|numeric',
            ]);

            TokoLelang::create([
                'nama_toko' => $validatedData['nama_toko'],
                'no_telepon' => $validatedData['no_telepon'],
                'nama_jalan' => $validatedData['nama_jalan'],
                'kelurahan' => $validatedData['kelurahan'],
                'kode_pos' => $validatedData['kode_pos'],
                'username_pengguna' => $request['username_pengguna'],
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Toko lelang berhasil dibuat',
            ]);
        } catch (\Exception $e) {
            $errorData = ['status' => false];

            if (empty($e->status)) {
                if (isset($e->errorInfo[1])) {
                    switch ($e->errorInfo[1]) {
                        case 1062:
                            $errorData['message'] = 'Anda sudah memiliki toko lelang';
                            break;
                        case 1216:
                            $errorData['message'] = 'Data pengguna tidak valid';
                            break;
                        default:
                            $errorData['message'] = 'Terjadi kesalahan pada database';
                            break;
                    }
                } else {
                    $errorData['message'] = 'Terjadi kesalahan pada server';
                }
            } else {
                $errorData['message'] = 'Input data tidak valid';
            }
            return response()->json($errorData, $e->status ?? 500);
        }
    }

    public function readShop($id)
    {
        try {
            $tokoLelang = TokoLelang::where('id', $id)->first();

            if ($tokoLelang) {
                return response()->json([
                    'status' => true,
                    'data' => $tokoLelang,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }
        } catch (\Exception $e) {
            $errorData = ['status' => false];

            if (isset($e->errorInfo[1])) {
                switch ($e->errorInfo[1]) {
                    default:
                        $errorData['message'] = 'Terjadi kesalahan pada database';
                        break;
                }
            } else {
                $errorData['message'] = 'Terjadi kesalahan pada server';
            }
            return response()->json($errorData, $e->status ?? 500);
        }
    }

    public function updateShop(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_toko' => 'required|max:255',
                'no_telepon' => 'required|max:20',
                'nama_jalan' => 'required|max:255',
                'kelurahan' => 'required|max:100',
                'kode_pos' => 'required|numeric',
            ]);

            $tokoLelang = TokoLelang::where('username_pengguna', $request['username_pengguna'])->first();

            if ($tokoLelang) {
                $tokoLelang->nama_toko = $validatedData['nama_toko'];
                $tokoLelang->no_telepon = $validatedData['no_telepon'];
                $tokoLelang->nama_jalan = $validatedData['nama_jalan'];
                $tokoLelang->kelurahan = $validatedData['kelurahan'];
                $tokoLelang->kode_pos = $validatedData['kode_pos'];
                $tokoLelang->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Informasi toko berhasil dibuat',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }
        } catch (\Exception $e) {
            $errorData = ['status' => false];

            if (empty($e->status)) {
                if (isset($e->errorInfo[1])) {
                    switch ($e->errorInfo[1]) {
                        default:
                            $errorData['message'] = 'Terjadi kesalahan pada database';
                            break;
                    }
                } else {
                    $errorData['message'] = 'Terjadi kesalahan pada server';
                }
            } else {
                $errorData['message'] = 'Input data tidak valid';
            }
            return response()->json($errorData, $e->status ?? 500);
        }
    }

    public function deleteShop()
    {
        try {
            $tokoLelang = TokoLelang::where('username_pengguna', $request['username_pengguna'])->first();

            if ($tokoLelang) {
                $tokoLelang->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Toko lelang berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ], 404);
            }
        } catch (\Exception $e) {
            $errorData = ['status' => false];

            if (isset($e->errorInfo[1])) {
                switch ($e->errorInfo[1]) {
                    default:
                        $errorData['message'] = 'Terjadi kesalahan pada database';
                        break;
                }
            } else {
                $errorData['message'] = 'Terjadi kesalahan pada server';
            }
            return response()->json($errorData, $e->status ?? 500);
        }
    }
}
