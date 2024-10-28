<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\EP;
use App\Models\EPRotation;
use App\Models\Rotation;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch basic statistics
        $totalStudents = Student::where('IsActive', 1)->count();
        $totalEPs = EP::where('IsActive', 1)->count();

        // Get current rotation
        $currentRotation = Rotation::where('IsActive', 1)
            ->where('StartDate', '<=', now())
            ->where('EndDate', '>=', now())
            ->first();

        // Get attendance statistics for the current week
        $weeklyAttendance = $this->getWeeklyAttendanceStats();

        // Get EP participation by center
        $epsByCenter = $this->getEPsByCenterStats();

        // Get gender distribution
        $genderDistribution = $this->getGenderDistribution();

        // Recent attendance records
        $recentAttendance = $this->getRecentAttendance();

        // Get upcoming EPs schedule
        $upcomingEPs = $this->getUpcomingEPs();

        return view('dashboard.index', compact(
            'totalStudents',
            'totalEPs',
            'currentRotation',
            'weeklyAttendance',
            'epsByCenter',
            'genderDistribution',
            'recentAttendance',
            'upcomingEPs'
        ));
    }

    /**
     * Get weekly attendance statistics.
     *
     * @return array
     */
    private function getWeeklyAttendanceStats()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        return Attendance::whereBetween('AttendanceDate', [$startOfWeek, $endOfWeek])
            ->select(
                DB::raw('DATE(AttendanceDate) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN Status = "Present" THEN 1 ELSE 0 END) as present')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($record) {
                $record->attendance_rate = $record->total > 0
                    ? round(($record->present / $record->total) * 100, 1)
                    : 0;
                return $record;
            });
    }

    /**
     * Get EP distribution by center statistics.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getEPsByCenterStats()
    {
        return DB::table('center')
            ->select([
                'center.CenterName',
                DB::raw('COUNT(DISTINCT ep.EPID) as total_eps'),
                DB::raw('COUNT(DISTINCT student_ep_rotation.StudentID) as total_students')
            ])
            ->leftJoin('ep', 'center.CenterID', '=', 'ep.CenterID')
            ->leftJoin('ep_rotation', 'ep.EPID', '=', 'ep_rotation.EPID')
            ->leftJoin('student_ep_rotation', 'ep_rotation.EP_RotationID', '=', 'student_ep_rotation.EP_RotationID')
            ->where('center.IsActive', 1)
            ->groupBy('center.CenterID', 'center.CenterName')
            ->get();
    }

    /**
     * Get gender distribution statistics.
     *
     * @return array
     */
    private function getGenderDistribution()
    {
        return Student::where('IsActive', 1)
            ->select('Gender', DB::raw('COUNT(*) as count'))
            ->groupBy('Gender')
            ->pluck('count', 'Gender')
            ->toArray();
    }

    /**
     * Get recent attendance records.
     *
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    private function getRecentAttendance($limit = 5)
    {
        return DB::table('attendance')
            ->join('student_ep_rotation', 'attendance.Student_EP_RotationID', '=', 'student_ep_rotation.Student_EP_RotationID')
            ->join('student', 'student_ep_rotation.StudentID', '=', 'student.StudentID')
            ->join('ep_rotation', 'student_ep_rotation.EP_RotationID', '=', 'ep_rotation.EP_RotationID')
            ->join('ep', 'ep_rotation.EPID', '=', 'ep.EPID')
            ->select([
                'student.FirstName',
                'student.LastName',
                'ep.EPName',
                'attendance.AttendanceDate',
                'attendance.Status',
                'attendance.CreatedAt'
            ])
            ->orderBy('attendance.CreatedAt', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get upcoming EPs schedule.
     *
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    private function getUpcomingEPs()
    {
        $currentRotation = Rotation::where('IsActive', 1)
            ->where('StartDate', '<=', now())
            ->where('EndDate', '>=', now())
            ->first();

        if (!$currentRotation) {
            return collect([]);
        }

        return DB::table('ep_rotation')
            ->join('ep', 'ep_rotation.EPID', '=', 'ep.EPID')
            ->join('user', 'ep_rotation.UserID', '=', 'user.UserID')
            ->where('ep_rotation.RotationID', $currentRotation->RotationID)
            ->where('ep_rotation.IsActive', 1)
            ->select([
                'ep.EPName',
                'user.FirstName as TeacherFirstName',
                'user.LastName as TeacherLastName',
                DB::raw('(SELECT COUNT(*) FROM student_ep_rotation WHERE EP_RotationID = ep_rotation.EP_RotationID) as student_count')
            ])
            ->get();
    }
}
