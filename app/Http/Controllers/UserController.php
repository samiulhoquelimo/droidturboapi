<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function index(): JsonResponse
    {
        if (!is_permission(auth()->user()->role_id, 'user.index')) {
            return response()->json([
                'status'  => false,
                'message' => 'You do not have permission for this'
            ]);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Success',
            'data'    => UserResource::collection(User::all())
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        if (!is_permission(auth()->user()->role_id, 'user.store')) {
            return response()->json([
                'status'  => false,
                'message' => 'You do not have permission for this'
            ]);
        }

        $input = $request->all();
        $input['created_by'] = auth()->id();

        try {
            $data = new UserResource(User::query()->create($input));
            return response()->json([
                'status'  => true,
                'message' => 'Successfully Created',
                'data'    => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->errorInfo[1] == 1062 ? 'Data is Found Duplicate' : 'Something Error Found! Please try again.'
            ]);
        }
    }

    public function show($id): JsonResponse
    {
        if (!is_permission(auth()->user()->role_id, 'user.index')) {
            return response()->json([
                'status'  => false,
                'message' => 'You do not have permission for this'
            ]);
        }

        try {
            $data = User::query()->findOrFail($id);
            return response()->json([
                'status'  => true,
                'message' => 'Success',
                'data'    => new User($data)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Data not exist'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->errorInfo[1] == 1062 ? 'Data is Found Duplicate' : 'Something Error Found! Please try again.'
            ]);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        if (!is_permission(auth()->user()->role_id, 'user.edit')) {
            return response()->json([
                'status'  => false,
                'message' => 'You do not have permission for this'
            ]);
        }

        $input = $request->all();
        $input['updated_by'] = auth()->id();

        try {
            $model = User::query()->findOrFail($id);
            $model->update($input);
            $model->save();
            $data = new User($model);
            return response()->json([
                'status'  => true,
                'message' => 'Successfully Updated',
                'data'    => $data
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Data not exist',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->errorInfo[1] == 1062 ? 'Data is Found Duplicate' : 'Something Error Found! Please try again.'
            ]);
        }
    }

    public function destroy($id): JsonResponse
    {
        if (!is_permission(auth()->user()->role_id, 'user.destroy')) {
            return response()->json([
                'status'  => false,
                'message' => 'You do not have permission for this'
            ]);
        }

        try {
            $data = User::query()->findOrFail($id);
            $input['deleted_by'] = auth()->id();
            $data->update($input);
            $data->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Successfully Deleted'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Data not exist'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->errorInfo[1] == 1451 ? 'This data is using, can not be deleted.' : 'Something Error Found! Please try again.'
            ]);
        }
    }
}
