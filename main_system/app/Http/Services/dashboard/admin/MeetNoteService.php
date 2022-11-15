<?php

namespace App\Http\Services\dashboard\admin;

use App\Http\Services\Service;
use App\Repositories\MeetNoteRepository;
use App\Repositories\MeetRepository;
use Illuminate\Http\Request;

class MeetNoteService extends Service
{
    private $meetNoteRepository;
    private $meetRepository;

    public function __construct()
    {
        $this->meetNoteRepository = new MeetNoteRepository();
        $this->meetRepository = new MeetRepository();
    }
    public function meets(array $columns = ["*"])
    {
        return $this->meetRepository->getMeets($columns);
    }
    public function storeMeet(Request $request, $note, $meet_id)
    {
        $this->validation($request, array("note" => ["required"], "meet_id" => ["required"]), array("required" => ":attribute tidak boleh kosong"));

        $data = array(
            "note" => $note,
            "meet_id" => $meet_id
        );
        $response = $this->meetNoteRepository->query()->create($data);

        if (!$response) return false;

        return true;
    }
    public function detailNote($id, array $columns = ["*"])
    {
        return $this->meetNoteRepository->getByID($id)->first($columns);
    }
    public function updateNote(Request $request, $id, $note)
    {
        $this->validation($request, array("note" => ["required"]), array("required" => ":attribute tidak boleh kosong"));
        $data = array(
            "note" => $note
        );
        return $this->meetNoteRepository->getByID($id)->update($data) == 1;
    }
    public function updateMeetNote(Request $request, $id, $meet_id)
    {
        $this->validation($request, array("meet_id" => ["required"]), array("required" => ":attribute tidak boleh kosong"));

        $data = array(
            "meet_id" => $meet_id
        );

        return $this->meetNoteRepository->getByID($id)->update($data) == 1;
    }
    public function meetNoteDetail($id, array $columns = ["*"])
    {
        return $this->meetNoteRepository->query()->where("meet_note.id", "=", $id)->join("meet", "meet.id", "=", "meet_note.meet_id")->first($columns);
    }
    public function deleteMeetNote($id)
    {
        return $this->meetNoteRepository->query()->where("id", "=", $id)->delete();
    }
    public function meetsByStatus($status, array $columns = ["*"])
    {
        return $this->meetRepository->query()->where("status", "=", $status)->get($columns);
    }
}
