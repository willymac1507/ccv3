<?php

use App\Domain\Appointment\Diary\Loaders\AppointmentLoader;
use App\Domain\Appointment\DTO\ScheduleItem;
use Carbon\Carbon;

$item = new ScheduleItem(new Carbon('07:30'), 1, ['id' => 1, 'name' => 'John'], ['id' => 1, 'name' => 'John'], 15);
dump($item);



//$appointments = AppointmentLoader::getAppointments($user->id, request('date'))
// $student = User::find($user->id);
// $shift = Shift::where(['user_id' => $user->id, 'day' => Carbon::parse(request('date'))->format('l')])->first();
// $cleanUpTime = new Carbon($shift['endTime'])->subMinutes(15)->format('H:i:s');
// $setUpAppt = [
//    'id' => 999999999999999997,
//    'date' => request('date'),
//    'time' => $shift['startTime'],
//    'student' => $user->id,
//    'client' => [
//        'id' => $user->id,
//        'name' => $user->name,
//    ],
//    'service' => [
//        'id' => 100,
//        'name' => 'Set up',
//        'min_duration' => 1,
//    ],
//    'status' => '',
// ];
// $appointments[] = $setUpAppt;
// $cleanUpAppt = [
//    'id' => 999999999999999998,
//    'date' => request('date'),
//    'time' => $cleanUpTime,
//    'student' => $user->id,
//    'client' => [
//        'id' => $user->id,
//        'name' => $user->name,
//    ],
//    'service' => [
//        'id' => 100,
//        'name' => 'Clean up',
//        'min_duration' => 1,
//    ],
//    'status' => '',
// ];
// $appointments[] = $cleanUpAppt;
// if ($shift['breakTime']) {
//    $break = [
//        'id' => 999999999999999999,
//        'date' => request('date'),
//        'time' => $shift['breakTime'],
//        'student' => $user->id,
//        'client' => [
//            'id' => $user->id,
//            'name' => $user->name,
//        ],
//        'service' => [
//            'id' => 100,
//            'name' => 'Break',
//            'min_duration' => $shift['duration'] / 15,
//        ],
//        'status' => '',
//    ];
