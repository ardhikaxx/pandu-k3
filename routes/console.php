<?php

use Illuminate\Support\Facades\Schedule;
use App\Models\Certificate;
use App\Models\CapaAction;
use App\Models\Inspection;
use App\Models\HazardReport;

// 1. Check Certificate Expiry (Daily 06:00)
Schedule::call(function () {
    Certificate::where('status', '!=', 'expired')
        ->where('expiry_date', '<', now())
        ->update(['status' => 'expired']);

    Certificate::where('status', 'active')
        ->where('expiry_date', '<=', now()->addDays(30))
        ->update(['status' => 'expiring_soon']);
})->dailyAt('06:00');

// 2. Update Overdue CAPA (Daily 07:00)
Schedule::call(function () {
    CapaAction::whereNotIn('status', ['closed', 'pending_verification'])
        ->where('due_date', '<', now())
        ->update(['status' => 'overdue']);
})->dailyAt('07:00');

// 3. Update Overdue Inspections (Daily 00:01)
Schedule::call(function () {
    Inspection::where('status', 'scheduled')
        ->where('scheduled_date', '<', now()->toDateString())
        ->update(['status' => 'overdue']);
})->dailyAt('00:01');

// 4. Check Hazard SLA (Hourly)
Schedule::call(function () {
    // Logic to escalate unhandled hazards based on priority
    // For emergency (> 1hr), urgent (> 4hr), normal (> 24hr)
    $emergencies = HazardReport::where('status', 'open')
        ->where('priority', 'emergency')
        ->where('reported_at', '<', now()->subHour())
        ->get();

    foreach ($emergencies as $hazard) {
        // Trigger escalation notification to HSE Manager
    }
})->hourly();
