<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Events\PanicButtonPressed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanicButtonController extends Controller
{
    public function trigger(Request $request)
    {
        $user = Auth::user();

        // Dispatch Event
        event(new PanicButtonPressed($user));

        // Notify relevant roles
        $notifiables = \App\Models\User::whereIn('role', ['super_admin', 'hse_manager'])
            ->orWhere(function($q) use ($user) {
                $q->where('role', 'supervisor')->where('division_id', $user->division_id);
            })->get();

        foreach ($notifiables as $person) {
            $person->notify(new \App\Notifications\GeneralNotification(
                "🚨 DARURAT: PANIC BUTTON!",
                "Pekerja {$user->name} menekan tombol darurat di area " . ($user->workArea->name ?? 'Tidak Diketahui'),
                '#'
            ));
        }

        // Log Activity
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'panic_button_pressed',
            'module' => 'emergency',
            'description' => "Emergency panic button pressed by {$user->name} in area " . ($user->workArea->name ?? 'Unknown'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Peringatan darurat telah dikirim ke seluruh tim keamanan dan supervisor.',
        ]);
    }
}
