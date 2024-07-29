<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Course;
use App\Models\CourseMonthLesson;
use App\Models\Invoice;
use App\Models\Subject;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke(){
        $teachers       = Admin::whereNull('is_admin')->count();

        $students       = User::count();
        $subscriptions  = Invoice::where('status', 1)->count();
        $subjects       = Subject::active()->count();
        $courses        = Course::count();
        $lessons        = CourseMonthLesson::count();

        $invoices = Invoice::orderBy('id', 'DESC')->limit(10)->get();

        return view('Admin.Dashboard', [
            'page_title' => 'أهلا بك في لوحة تحكم بوابة العلوم',
            'students' => $students,
            'subscriptions' => $subscriptions,
            'subjects' => $subjects,
            'teachers' => $teachers,
            'courses' => $courses,
            'invoices' => $invoices,
            'lessons' => $lessons,
            'views' => 0
        ]);
    }
}
