<?php


namespace App\Http\Services;

use Illuminate\Http\Request;

interface AbstractService
{
    public function validation(Request $request, array $rules = [],  $customMessage = []): array;

    public function create($model, array $data);

    public function read();

    public function update($model, string $rowName, string $id, array $data);

    public function delete();
}



class Service implements AbstractService
{

    public function validation(Request $request, array $rules = [], $customMessage = []): array
    {
        $validate = $request->validate($rules, $customMessage);
        return $validate;
    }
    public function create($model, array $data)
    {
        return $model->create($data);
    }
    public function update($model, string $rowName,  string $id, array $data)
    {
        return $model->query()->where($rowName, "=", $id)->update($data);
    }
    public function delete()
    {
    }
    public function read()
    {
    }
}
