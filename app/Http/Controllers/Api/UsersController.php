<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function importUsers(Request $request, UserRepository $userRepository): JsonResponse
    {
        $countToImport = $request->get('count_users_to_import') ?: 5000;
        $importResult = $userRepository->importRandomUsers($countToImport);

        return response()->json($importResult, isset($importResult['error']) ? 500 : 200);
    }

    public function getCountUsers(User $user): JsonResponse
    {
        $count = $user->count();
        return response()->json(['users_count' => $count]);
    }
}
