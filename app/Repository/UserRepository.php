<?php


namespace App\Repository;

use App\Contracts\RandomUserContract;
use App\DTO\UserDTO;
use App\Models\User;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function importRandomUsers($countToImport): array
    {
        try {
            DB::beginTransaction();

            $data = app(RandomUserContract::class)->getRandomUsers($countToImport);

            if ($data instanceof GuzzleException) {
                DB::rollBack();
                $errorResponse = $data->getResponse();
                $errorMessage = json_decode($errorResponse->getBody()->getContents(), true);
                isset($errorMessage['error'])
                    ? $error = $errorMessage['error']
                    : $error = $errorResponse->getReasonPhrase();

                return ['error' => $error];
            }

            $usersToSave = $this->prepareUsersData($data);

            $totalCountUsersBeforeUpdate = User::count();
            User::upsert($usersToSave, ['first_name', 'last_name'], ['email', 'age']);
            $totalCountUsersAfterUpdate = User::count();

            DB::commit();

            return [
                'success' => 'Import completed',
                'inserted' => $totalCountUsersAfterUpdate - $totalCountUsersBeforeUpdate,
                'updated' => count($usersToSave) - ($totalCountUsersAfterUpdate - $totalCountUsersBeforeUpdate),
                'total' => $totalCountUsersAfterUpdate,
            ];
        } catch (\Throwable $e) {
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    protected function prepareUsersData($data): array
    {
        $userDTO = new UserDTO();

        return array_map(function ($userData) use ($userDTO) {
            $userDTO->first_name = $userData['name']['first'];
            $userDTO->last_name = $userData['name']['last'];
            $userDTO->email = $userData['email'];
            $userDTO->age = $userData['dob']['age'];

            return [
                'first_name' => $userDTO->first_name,
                'last_name' => $userDTO->last_name,
                'email' => $userDTO->email,
                'age' => $userDTO->age,
            ];
        }, $data['results']);
    }
}
