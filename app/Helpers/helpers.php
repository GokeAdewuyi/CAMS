<?php

use App\Models\Semester;

if (!function_exists("get_current_semester")) {
    function get_current_semester() {
        if (session('current_semester'))
            return Semester::find(session('current_semester'));
        return Semester::where('status', 'current')->first();
    }
}

if (!function_exists("get_current_semester_status")) {
    function get_current_semester_status() {
        if (session('current_semester'))
            return Semester::find(session('current_semester'))->status;
        return Semester::where('status', 'current')->first()->status;
    }
}

if (!function_exists("get_current_semester_id")) {
    function get_current_semester_id() {
        return session('current_semester') ?? Semester::where('status', 'current')->first()->id;
    }
}
