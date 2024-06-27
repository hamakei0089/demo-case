<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stamp;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;

class StampController extends Controller
{
    public function startwork(){
        $currentDatetime = now();
        $userId = Auth::id();

        Stamp::create([
            'user_id' => $userId,
            'work_start' => $currentDatetime,
            'work_end' => null
        ]);
        return redirect()->back()->with('success', '勤務開始時間を記録しました。');
    }

    public function endwork()
{
    $currentDatetime = now();
    $userId = Auth::id();

    $stamp = Stamp::where('user_id', $userId)->whereNull('work_end')->latest()->first();

    if ($stamp) {

        if ($stamp->work_start->day != $currentDatetime->day) {

            $stamp->work_end = $stamp->work_start->copy()->endOfDay();
            $stamp->save();


            $newStamp = new Stamp([
                'user_id' => $userId,
                'work_start' => $currentDatetime->copy()->startOfDay(),
            ]);
            $newStamp->save();


            $newStamp->work_end = $currentDatetime;
            $newStamp->save();

            return redirect()->back()->with('success', '勤務終了時間を記録しました。次の日の勤務開始時間も記録しました。');
        } else {

            $stamp->work_end = $currentDatetime;
            $stamp->save();

            return redirect()->back()->with('success', '勤務終了時間を記録しました。');
        }
    }

    return redirect()->back()->with('error', 'まだ勤務を開始していません。');
}

    public function startrest(){
        $currentDatetime = now();
        $userId = Auth::id();

        $stamp = Stamp::where('user_id', $userId)->whereNull('work_end')->latest()->first();

        if ($stamp) {
            Rest::create([
                'stamp_id' => $stamp->id,
                'rest_start' => $currentDatetime,
                'rest_end' => null
            ]);
            return redirect()->back()->with('success', '休憩開始時間を記録しました。');
        }

            return redirect()->back()->with('error', '勤務開始記録がありません。');

    }

    public function endrest(){
        $currentDatetime = now();
        $userId = Auth::id();

        $stamp = Stamp::where('user_id', $userId)->whereNull('work_end')->latest()->first();

        if ($stamp) {
            $rest = Rest::where('stamp_id', $stamp->id)->whereNull('rest_end')->latest()->first();

            if ($rest) {
                $rest->update(['rest_end' => $currentDatetime]);

            return redirect()->back()->with('success', '休憩終了時間を記録しました。');
            }

            return redirect()->back()->with('error', 'まだ休憩を開始していません。');
        }

            return redirect()->back()->with('error', '勤務開始記録がありません。');
    }

}