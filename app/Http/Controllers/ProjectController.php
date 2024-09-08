<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Interfaces\ProjectRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    private ProjectRepositoryInterface $projectRepositoryInterface;

    public function __construct(ProjectRepositoryInterface $projectRepositoryInterface)
    {
        $this->projectRepositoryInterface = $projectRepositoryInterface;
    }

    public function index(): JsonResponse
    {
        $data = $this->projectRepositoryInterface->index();
        return ApiResponseClass::sendResponse(
            ProjectResource::collection($data),
            '',
        );
    }

    public function store(ProjectRequest $request): JsonResponse
    {
        $details = $request->validated();
        $details['created_by'] = auth()->user()->id;

        DB::beginTransaction();
        try {
            $product = $this->projectRepositoryInterface->store($details);

            DB::commit();
            return ApiResponseClass::sendResponse(
                new ProjectResource($product),
                'Project created successfully',
                201
            );
        } catch (HttpResponseException $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $product = $this->projectRepositoryInterface->getById($id);
            return ApiResponseClass::sendResponse(new ProjectResource($product));
        } catch (Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    public function update(UpdateProjectRequest $request, $id): JsonResponse
    {
        $updateDetails = $request->validated();
        DB::beginTransaction();

        try {
            $this->projectRepositoryInterface->update($updateDetails, $id);

            DB::commit();
            return ApiResponseClass::sendResponse(
                new ProjectResource($this->projectRepositoryInterface->getById($id)),
                'Project updated successfully'
            );
        } catch (Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    public function destroy($id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $this->projectRepositoryInterface->delete($id);
            DB::commit();
            return ApiResponseClass::sendResponse(
                [],
                'Project deleted successfully',
                204
            );
        } catch (Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }
}
