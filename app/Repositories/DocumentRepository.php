<?php

namespace App\Repositories;

use App\Models\Document;

class DocumentRepository extends Document
{
    public function getDocuments(array $columns = array("*"))
    {
        return $this->query()->get($columns);
    }
    public function documentByID($id, array $columns = ["*"])
    {
        return $this->query()->where("id", "=", $id)->first($columns);
    }
}
