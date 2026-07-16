<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Catat pengunjung unik per hari berdasarkan IP address.
     * Jika jamaah sedang login, user_id-nya ikut dicatat agar
     * setiap jamaah dihitung sebagai satu kunjungan terpisah.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $today = now()->toDateString();
        $page = $request->path() ?: '/';
        $userId = Auth::id();

        // Pengunjung unik: kombinasi user_id + ip_address + hari ini.
        // Jamaah yang login dihitung per user; tamu (guest) dihitung per IP.
        Visitor::firstOrCreate([
            'user_id' => $userId,
            'ip_address' => $ip,
            'visited_at' => $today,
        ], [
            'page' => $page,
            'user_agent' => $request->userAgent(),
        ]);

        return $next($request);
    }
}
