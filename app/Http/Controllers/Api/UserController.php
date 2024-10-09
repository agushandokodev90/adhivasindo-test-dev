<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AddUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use JsonResponse;

    public function list(Request $request)
    {
        $limit = $request->get('limit', 10);
        $page = $request->get('page', 1);
        $sortBy = $request->get('sortBy', 'name');
        $sortType = $request->get('sortType', 'asc');
        $search = $request->get('search');

        $list = User::query();
        if ($request->filled('search')) {
            $list->where(function ($qry) use ($search) {
                $qry->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        $list->orderBy($sortBy, $sortType);
        $data = $this->paging($list, $limit, $page);
        return $this->successResponse($data);
    }

    public function detail(User $user)
    {
        return $this->successResponse($user);
    }

    public function add(AddUserRequest $request)
    {
        User::create($request->validated());
        return $this->successResponse();
    }

    public function update(UpdateUserRequest $request,User $user)
    {
        $user->update($request->validated());
        return $this->successResponse();
    }

    public function remove(User $user)
    {
        $user->delete();
        return $this->successResponse($user);
    }
}
