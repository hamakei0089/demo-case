<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Stamp;
use App\Models\Rest;
use App\Models\Attendance;
use Carbon\Carbon;


class AttendanceController extends Controller
{

   public function index(Request $request)
{
    $date = $request->input('date', Carbon::today()->toDateString());
    $currentDate = Carbon::parse($date);
    $previousDate = $currentDate->copy()->subDay()->toDateString();
    $nextDate = $currentDate->copy()->addDay()->toDateString();


    $stamps = Stamp::whereDate('work_start', $currentDate)->with('user', 'rests')->paginate(5)->appends(['date' => $date]);
    if ($stamps->isEmpty()) {
        return view('attendance', compact('stamps', 'currentDate', 'previousDate', 'nextDate'))
            ->with('message', '指定された日付には勤務データがありません。');
    }


    $attendanceData = $stamps->map(function ($stamp) {
        $user = $stamp->user;
        $workStart = $stamp->work_start ? Carbon::parse($stamp->work_start)->format('H:i:s') : null;
        $workEnd = $stamp->work_end ? Carbon::parse($stamp->work_end)->format('H:i:s') : null;


        $rests = $stamp->rests;
        $restDuration = $rests->sum(function ($rest) {
            return $rest->rest_end
                ? Carbon::parse($rest->rest_end)->diffInMinutes(Carbon::parse($rest->rest_start))
                : 0;
        });


        $isResting = $rests->contains(function ($rest) {
            return is_null($rest->rest_end);
        });

        if ($stamp->work_start && !$stamp->work_end && !$isResting) {
            $stamp->update(['work_end' => Carbon::parse($stamp->work_start)->endOfDay()]);
            Stamp::create([
                'user_id' => $stamp->user_id,
                'work_start' => Carbon::parse($stamp->work_start)->addDay()->startOfDay(),
            ]);
        }


        $formattedRestDuration = $isResting ? '休憩中' : gmdate('H:i:s', $restDuration * 60);
        $formattedWorkDuration = $workEnd
            ? gmdate('H:i:s', Carbon::parse($stamp->work_end)->diffInSeconds(Carbon::parse($stamp->work_start)) - $restDuration * 60)
            : '勤務中';

        return [
            'name' => $user->name,
            'work_start' => $workStart,
            'work_end' => $workEnd,
            'rest_duration' => $formattedRestDuration,
            'work_duration' => $formattedWorkDuration,
        ];
    });

    return view('attendance', compact('stamps', 'attendanceData', 'currentDate', 'previousDate', 'nextDate'))
        ->with('message', '');
}
}
