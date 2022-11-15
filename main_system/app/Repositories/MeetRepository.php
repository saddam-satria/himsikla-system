<?php


namespace App\Repositories;

use App\Models\Meet;

class MeetRepository extends Meet
{
    public function getByMeetID(string $id, array $columns = ["*"])
    {
        return $this->query()->where("id", "=", $id)->first($columns);
    }
    public function updateMeetByID(string $id, $data)
    {
        return $this->query()->where("id", "=", $id)->update($data);
    }
    public function getMeets(array $columns = ["*"])
    {
        return $this->query()->get($columns);
    }
}
