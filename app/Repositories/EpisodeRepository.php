<?php

namespace App\Repositories;

use App\Models\Episode;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\EpisodeContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\DB;

/**
 * Class CategoryRepository
 *
 * @package \App\Repositories
 */
class EpisodeRepository extends BaseRepository implements EpisodeContract
{
    use UploadAble;

    /**
     * CategoryRepository constructor.
     * @param Episode $model
     */
    public function __construct(Episode $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }



    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findEpisodeById(int $id)
    {
        try {
            return $this->model::whereId($id)->with('episodes')->firstOrFail();
        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Episode|mixed
     */
    public function createEpisode(int $course_id, array $params)
    {
        try {
            $collection = collect($params);
            foreach ($collection as  $value) {
                $value['course_id'] = $course_id;
                $episode =  $this->model::create($value);
            }

            return $episode;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateEpisode(array $params)
    {
        $episode = $this->findEpisodeById($params['id']);

        $collection = collect($params)->except('_token');

        if ($collection->has('logo') && ($params['logo'] instanceof  UploadedFile)) {

            if ($episode->logo != null) {
                $this->deleteOne($episode->logo);
            }

            $logo = $this->uploadOne($params['logo'], 'episodes');
        }

        $merge = $collection->merge(compact('logo'));

        $episode->update($merge->all());

        return $episode;
    }




    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteEpisode($id)
    {
        $episode = $this->findEpisodeById($id);

        if ($episode->logo != null) {
            $this->deleteOne($episode->logo);
        }

        $episode->delete();

        return $episode;
    }
}
