<?php

namespace App\Http\Controllers;

use App\Contracts\CourseContract;
use App\Contracts\EpisodeContract;
use App\Http\Requests\CourseRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends BaseController
{
    /**
     * @var CourseContract
     */
    protected $courseRepository;
    protected $episodeRepository;

    /**
     * CategoryController constructor.
     * @param CourseContract $courseRepository
     */

    public function __construct(CourseContract $courseRepository, EpisodeContract $episodeRepository)
    {
        $this->courseRepository = $courseRepository;
        $this->episodeRepository = $episodeRepository;
    }
    public function index()
    {
        $courses = $this->courseRepository->listCourses();
        return Inertia::render('Courses/Index', compact('courses'));
    }

    public function show(int $id)
    {
        $course = $this->courseRepository->findCourseById($id);
        $watched = auth()->user()->episodes;

        return Inertia::render('Courses/Show', compact('course', 'watched'));
    }
    public function store(CourseRequest $request)
    {
        $course = $this->courseRepository->createCourse($request->all());
        $this->episodeRepository->createEpisode($course->id, $request->input('episodes'));
        return $this->responseRedirect('courses.index', 'Course created successfully', 'success', false, false);
    }
    public function edit(int $id)
    {
        $course = $this->courseRepository->findCourseById($id);
        $this->authorize('update', $course);
        return Inertia::render('Courses/Edit', compact('course'));
    }
    public function update(CourseRequest $request)
    {
        $course = $this->courseRepository->updateCourse($request->all());
        $this->episodeRepository->createEpisode($course->id, $request->input('episodes'));
        return $this->responseRedirect('courses.index', 'Course updated successfully', 'success', false, false);
    }
    public function toggleProgress(Request $request)
    {
        $id = $request->input('episodeId');

        $episodes_user = $this->courseRepository->toggleProgressCourse($id);
        return $episodes_user;
    }
}
