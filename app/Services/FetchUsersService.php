<?php

namespace App\Services;

use App\Contracts\FetchUserServiceInterface;
use App\Models\User;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 *
 */
class FetchUsersService implements FetchUserServiceInterface
{
    private int $limit;
    private array $collections;

    /**
     *
     */
    public function __construct()
    {
        $this->collections = [];
    }

    /**
     * @param int $limit
     * @return bool
     */
    public function call(int $limit): bool
    {
        try {
            $this->limit = $limit;
            $this->collectData($this->getFromApi());
            $this->filterCollections();
            $this->store();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        } finally {
            return true;
        }
    }


    /**
     * @param mixed $users
     * @return void
     */
    private function collectData(mixed $users): void
    {
        foreach ($users as $user) {
            $temp = [];
            $temp['uuid'] = $user['login']['uuid'];
            $temp['name'] = json_encode($user['name']);
            $temp['gender'] = $user['gender'];
            $temp['location'] = json_encode($user['location']);
            $temp['age'] = $user['dob']['age'];
            $temp['created_at'] = Carbon::now();
            $temp['updated_at'] = Carbon::now();

            $this->collections[] = $temp;
        }
    }

    /**
     * @return array|mixed
     */
    private function getFromApi(): mixed
    {
        $response = Http::get('https://randomuser.me/api/?results=' . $this->limit);
        $response = $response->json();

        return (empty($response)) ? [] : $response['results'];
    }

    /**
     * @return void
     */
    private function filterCollections(): void
    {
        $exists = $this->existingIds(collect($this->collections)->pluck('uuid')->all());

        $this->collections = array_filter($this->collections, function ($item) use ($exists) {
            return !in_array($item['uuid'], $exists);
        });
    }

    /**
     * @param array $ids
     * @return array
     */
    private function existingIds(array $ids): array
    {
        return User::select('uuid')
            ->whereIn('uuid', $ids)
            ->get()
            ->pluck('uuid')
            ->toArray();
    }

    /**
     * @return void
     */
    private function store(): void
    {
        User::insert($this->collections);
    }
}
