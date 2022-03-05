<?php

namespace App\Http\Controllers;

use App\Contracts\CourseContract;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends Controller
{
    /**
     * @var CourseContract
     */
    protected $courseRepository;

    /**
     * CategoryController constructor.
     * @param CourseContract $courseRepository
     */

    public function __construct(CourseContract $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }
    public function index()
    {
        $courses = $this->courseRepository->listCourses();
        return Inertia::render('Courses/Index', compact('courses'));
    }

    public function show($id)
    {
        $course = $this->courseRepository->findCourseById($id);
        $watched = auth()->user()->episodes;

        return Inertia::render('Courses/Show', compact('course', 'watched'));
    }
    public function toggleProgress(Request $request)
    {
        $id = $request->input('episodeId');

        $episodes_user = $this->courseRepository->toggleProgressCourse($id);
        return $episodes_user;
    }
}
