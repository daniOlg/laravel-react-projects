<?php

namespace App\Repositories;

use App\Interfaces\ProjectRepositoryInterface;
use App\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function index()
    {
        return Project::all();
    }

    public function getById($id)
    {
        return Project::query()->findOrFail($id);
    }

    public function store(array $data)
    {
        return Project::query()->create($data);
    }

    public function update(array $data, $id)
    {
        return Project::query()->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        Project::destroy($id);
    }
}
