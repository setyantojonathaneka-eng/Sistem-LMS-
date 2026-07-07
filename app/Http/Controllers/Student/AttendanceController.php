<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function checkin()
    {
        $alreadyToday = Attendance::where('user_id', Auth::id())
            ->whereDate('created_at', today())
            ->exists();

        if ($alreadyToday) {
            return back()->with('join_error', 'Kamu sudah absen hari ini.');
        }

        Attendance::create([
            'user_id' => Auth::id(),
            'status'  => 'hadir',
        ]);

        return back()->with('join_success', 'Absen berhasil!');
    }
}
