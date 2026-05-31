<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil guru dari relasi (user punya guru_id)
        $guru = $user->guru;

        // Sapaan waktu
        $hour = now()->hour; // integer 0–23

            if ($hour >= 4 && $hour < 11) {
                $sapaan = 'Selamat Pagi';
            } elseif ($hour >= 11 && $hour < 15) {
                $sapaan = 'Selamat Siang';
            } elseif ($hour >= 15 && $hour < 18) {
                $sapaan = 'Selamat Sore';
            } else {
                $sapaan = 'Selamat Malam';
            }


        // Kata mutiara pendidikan
        $quotes = [
            "Pendidikan bukanlah proses mengisi wadah yang kosong, melainkan proses menyalakan api pikiran. — W.B. Yeats",
            "Satu anak, satu guru, satu buku, dan satu pena dapat mengubah dunia. — Malala Yousafzai",
            "Orang hebat bisa melahirkan beberapa karya bermutu, tapi guru yang bermutu dapat melahirkan ribuan orang hebat.",
            "Tugas guru bukan memangkas hutan belantara menjadi ladang, tapi mengairi gurun agar berbunga.",
            "Seni tertinggi guru adalah membangkitkan kegembiraan dalam ekspresi kreatif dan pengetahuan. — Albert Einstein",
            "Apa yang ingin dipelajari murid sama pentingnya dengan apa yang ingin diajarkan guru."
        ];

        // Acak setiap refresh / login
        $quote = $quotes[array_rand($quotes)];

        return view('dashboard', compact(
            'sapaan',
            'guru',
            'quote'
        ));
    }
}
