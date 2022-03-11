<?php

namespace App\Contracts;

use Illuminate\Support\Facades\Request;

/**
 * Interface CourseContract
 * @package App\Contracts
 */
interface EpisodeContract
{
   
    /**
     * @param int $id
     * @return mixed
     */
    public function findEpisodeById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createEpisode(int $course_id,array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateEpisode(array $params);



    /**
     * @param $id
     * @return bool
     */
    public function deleteEpisode($id);
}
