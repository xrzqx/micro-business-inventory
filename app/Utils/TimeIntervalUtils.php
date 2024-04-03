<?php
namespace App\Utils;    
use Carbon\Carbon;

class TimeIntervalUtils
{
    function iterate_time_intervals($timestampStart, $timestampEnd) {
        $intervals = [];
    
        // Today
        $intervals['today'] = [
            'start' => Carbon::today()->startOfDay()->timestamp,
            'end' => Carbon::today()->endOfDay()->timestamp,
        ];
    
        // Yesterday
        $intervals['yesterday'] = [
            'start' => Carbon::yesterday()->startOfDay()->timestamp,
            'end' => Carbon::yesterday()->endOfDay()->timestamp,
        ];
    
        // Last 7 days
        $intervals['last_7_days'] = [
            'start' => Carbon::today()->subDays(6)->startOfDay()->timestamp,
            'end' => Carbon::today()->endOfDay()->timestamp,
        ];
    
        // Last 30 days
        $intervals['last_30_days'] = [
            'start' => Carbon::today()->subDays(29)->startOfDay()->timestamp,
            'end' => Carbon::today()->endOfDay()->timestamp,
        ];
    
        // Last 60 days
        $intervals['last_60_days'] = [
            'start' => Carbon::today()->subDays(59)->startOfDay()->timestamp,
            'end' => Carbon::today()->endOfDay()->timestamp,
        ];
    
        // Last 90 days
        $intervals['last_90_days'] = [
            'start' => Carbon::today()->subDays(89)->startOfDay()->timestamp,
            'end' => Carbon::today()->endOfDay()->timestamp,
        ];

        $intervals['all_time'] = [
            'start' => $timestampStart,
            'end' => $timestampEnd,
        ];
    
        return $intervals;
    }
}
