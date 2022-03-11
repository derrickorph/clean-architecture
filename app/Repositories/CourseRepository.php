<?php

namespace App\Repositories;

use App\Models\Course;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\CourseContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\DB;

/**
 * Class CategoryRepository
 *
 * @package \App\Repositories
 */
class CourseRepository extends BaseRepository implements CourseContract
{
    use UploadAble;

    /**
     * CategoryRepository constructor.
     * @param Course $model
     */
    public function __construct(Course $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCourses(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->model::with('user')
            ->select('courses.*', DB::raw(
                '(SELECT COUNT(DISTINCT(user_id))
            FROM completions
            INNER JOIN episodes ON completions.episode_id= episodes.id
            WHERE episodes.course_id= courses.id

            ) AS participants'
            ))
            ->withCount('episodes')->latest()->paginate(5);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCourseById(int $id)
    {
        try {
            return $this->model::whereId($id)->with('episodes')->firstOrFail();
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Course|mixed
     */
    public function createCourse(array $params)
    {
        try {
            $collection = collect($params);

            $course = new Course($collection->all());

            $course->save();


            return $course;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCourse(array $params)
    {
        $course = $this->findCourseById($params['id']);

        $collection = collect($params);

        $course->update($collection->all());
        $course->episodes()->delete();


        return $course;
    }

    public function toggleProgressCourse(int $id)
    {
        $user = auth()->user();
        $user->episodes()->toggle($id);
        return $user->episodes;
    }


    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteCourse($id)
    {
        $course = $this->findCourseById($id);

        if ($course->logo != null) {
            $this->deleteOne($course->logo);
        }

        $course->delete();

        return $course;
    }
}
