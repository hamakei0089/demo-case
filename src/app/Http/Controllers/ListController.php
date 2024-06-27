<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Stamp;
use App\Models\Rest;
use Carbon\Carbon;

class ListController extends Controller
{
    public function index(Request $request)
    {
        $currentDate = Carbon::today();

        $users = User::with(['stamps' => function ($query) use ($currentDate) {
            $query->whereDate('work_start', $currentDate)->with('rests');
        }])->paginate(5);

        $users->transform(function($user) {
            $stamps = $user->stamps;
            $rests = $stamps->flatMap(function ($stamp) {
                return $stamp->rests;
            });

            if ($stamps->isNotEmpty()) {
                if ($stamps->whereNotNull('work_end')->isEmpty() && $rests->whereNull('rest_end')->isEmpty()) {
                    $user->status = '勤務中';
                } elseif ($rests->whereNull('rest_end')->isNotEmpty()) {
                    $user->status = '休憩中';
                } else {
                    $user->status = '退勤';
                }
            } else {
                $user->status = '退勤';
            }

            return $user;
        });

        return view('list', compact('users'));
    }

    public function detail($id){

    $user = User::with(['stamps.rests'])->findOrFail($id);

    $stamps = $user->stamps()->with('rests')->orderBy('work_start', 'desc')->paginate(5);

    $attendanceData = $stamps->map(function($stamp) {

        $workStart = $stamp->work_start;
        $workEnd = $stamp->work_end;

        $restDuration = $stamp->rests->sum('rest_duration');

        $isResting = $stamp->rests->where('rest_end', null)->isNotEmpty();


        $workDuration = $workStart && $workEnd ? $workStart->diffInMinutes($workEnd) - $restDuration : null;

        $formattedWorkStart = $workStart ? $workStart->format('H:i:s') : null;
    $formattedWorkEnd = $workEnd ? $workEnd->format('H:i:s') : null;
        $formattedRestDuration = $isResting ? '休憩中' : gmdate('H:i:s', $restDuration * 60);
        $formattedWorkDuration = $workEnd
            ? gmdate('H:i:s', Carbon::parse($workEnd)->diffInSeconds(Carbon::parse($workStart)) - $restDuration * 60)
            : '勤務中';


        return [
            'date' => $workStart ? $workStart->format('Y-m-d') : null,
            'work_start' => $formattedWorkStart,
            'work_end' => $formattedWorkEnd,
            'rest_duration' => $formattedRestDuration,
            'work_duration' => $formattedWorkDuration,
        ];
    });


    return view('personal', compact('user', 'attendanceData','stamps'));
}
}
