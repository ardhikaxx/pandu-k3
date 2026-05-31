<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('generateDocumentNumber')) {
    function generateDocumentNumber(string $prefix, string $model, string $column = 'report_number'): string {
        $year = now()->format('Y');
        $lastRecord = DB::table(app($model)->getTable())
            ->whereYear('created_at', $year)
            ->orderBy('id','desc')
            ->first();
        $sequence = $lastRecord ? (intval(substr($lastRecord->$column, -5)) + 1) : 1;
        return "{$prefix}-{$year}-" . str_pad($sequence, 5, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('calculateRiskLevel')) {
    function calculateRiskLevel(int $score): string {
        return match(true) {
            $score <= 4  => 'very_low',
            $score <= 9  => 'low',
            $score <= 14 => 'medium',
            $score <= 19 => 'high',
            default      => 'very_high',
        };
    }
}

if (!function_exists('getRiskBadgeClass')) {
    function getRiskBadgeClass(string $level): string {
        return match($level) {
            'very_low' => 'badge-risk-vlow',
            'low'      => 'badge-risk-low',
            'medium'   => 'badge-risk-medium',
            'high'     => 'badge-risk-high',
            'very_high'=> 'badge-risk-critical',
            default    => 'badge-secondary',
        };
    }
}

if (!function_exists('determinePriority')) {
    function determinePriority(string $severity): string {
        return match($severity) {
            'critical' => 'emergency',
            'high'     => 'urgent',
            default    => 'normal',
        };
    }
}
