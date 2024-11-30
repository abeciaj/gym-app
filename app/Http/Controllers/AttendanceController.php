<?php

namespace App\Http\Controllers;
use App\Models\Gym;
use App\Models\User;
use App\Models\Attendance;
use App\Models\TrainingSession;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function listHistory(Request $request)
    {
        $query = Attendance::select(DB::raw('training_sessions.name as training_session_name, gyms.name as gym_name, cities.name as gym_city, 
            DATE(attendances.attendance_at) as attendance_date, TIME(attendances.attendance_at) as attendance_time, 
            users.name as name, users.email as email'))
            ->join('users', 'users.id', '=', 'attendances.user_id')
            ->join('training_sessions', 'training_sessions.id', '=', 'attendances.training_session_id')
            ->join('gyms', 'gyms.id', '=', 'users.gym_id')
            ->join('cities', 'gyms.city_id', '=', 'cities.id');

        // Apply search filter if provided
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', '%' . $search . '%')
                ->orWhere('users.email', 'like', '%' . $search . '%')
                ->orWhere('training_sessions.name', 'like', '%' . $search . '%')
                ->orWhere('gyms.name', 'like', '%' . $search . '%')
                ->orWhere('cities.name', 'like', '%' . $search . '%');
            });
        }

        // Paginate results
        $historyAttendances = $query->paginate(10); // Adjust number of items per page as needed

        // If no history and no search, show empty view
        if ($historyAttendances->isEmpty() && !$request->has('search')) {
            return view('empty');
        }

        return view('attendance', [
            'attendances' => $historyAttendances,
            'search' => $request->input('search', ''), // Pass search term back to the view
        ]);
    }



}
