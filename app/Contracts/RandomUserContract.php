<?php


namespace App\Contracts;


interface RandomUserContract
{
    public function getRandomUsers (int $count_users_to_import);
}
