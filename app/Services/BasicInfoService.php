<?php

namespace App\Services\Back;

/*use App\Model\Back\BasicInfo;
use App\Services\BaseService;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class BasicInfoService extends BaseService
{
    public function query(): Builder
    {
        $query = DB::table('basic_info')
            ->leftJoin('users as profile', 'basic_info.user_id', '=', 'profile.id')
            ->leftJoin('users as user_created', 'basic_info.created_by', '=', 'user_created.id')
            ->leftJoin('users as user_updated', 'basic_info.updated_by', '=', 'user_updated.id')
            ->leftJoin('users as user_deleted', 'basic_info.deleted_by', '=', 'user_deleted.id')
            ->select([
                'basic_info.*',
                'profile.user_name as profile_name',
                'user_created.user_name as created_name',
                'user_updated.user_name as updated_name',
                'user_deleted.user_name as deleted_name'
            ]);

        if (auth()->check() && auth()->id() != 1) {
            $query = $query->whereNull('basic_info.deleted_at');
        }

        return $query;
    }

    public function index()
    {
        return view('back.basic_info');
    }

    public function store(array $input): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = BasicInfo::query()->create($input);

            DB::commit();
            return $this->responseSuccess($data);
        } catch (Exception $e) {
            DB::rollback();
            return $this->responseError($e);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $data = BasicInfo::query()->findOrFail($id);
            return $this->responseSuccess($data);
        } catch (Exception $e) {
            return $this->responseError($e);
        }
    }

    public function edit($id): JsonResponse
    {
        try {
            $data = BasicInfo::query()->findOrFail($id);
            return $this->responseSuccess($data);
        } catch (Exception $e) {
            return $this->responseError($e);
        }
    }

    public function update(array $input, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = BasicInfo::query()->findOrFail($id);

            $data->update($input);

            DB::commit();

            return $this->responseSuccess($data);
        } catch (Exception $e) {
            DB::rollback();
            return $this->responseError($e);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $data = BasicInfo::query()->findOrFail($id);
            $input['deleted_by'] = auth()->id();
            $data->update($input);
            $data->delete();
            return $this->responseSuccess($data);
        } catch (Exception $e) {
            return $this->responseError($e);
        }
    }
}*/
