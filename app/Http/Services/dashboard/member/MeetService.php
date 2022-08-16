<?php

namespace App\Http\Services\dashboard\member;

use App\Http\Services\Service;
use App\Models\Meet;
use App\Repositories\MeetRepository;

class MeetService extends Service
{
    private $meetRepository;
    public function __construct()
    {
        $this->meetRepository = new MeetRepository();
    }
    public function getMeets(array $columns = ["*"])
    {
        return $this->meetRepository->getMeets($columns);
    }
    public function getMeet($id, array $columns = ["*"])
    {
        return Meet::query()->where("id", "=", $id)->first($columns);
    }
    public function getMeetWithNoteAbsence($id)
    {
        return Meet::query()->where("id", "=", $id)->withCount("absence")->first();
    }
}
