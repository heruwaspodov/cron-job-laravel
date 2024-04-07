<?php

namespace App\Services;

use App\Contracts\DefaultServiceInterface;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

/**
 *
 */
class HourlyCalculateService implements DefaultServiceInterface
{
    private const FEMALE = 'female';
    private const MALE = 'male';
    private int $totalMale;
    private int $totalFemale;

    public function __construct()
    {
        $this->totalMale = 0;
        $this->totalFemale = 0;
    }


    /**
     * @return bool
     */
    public function call(): bool
    {
        try {
            $this->countingFemale();
            $this->countingMale();
            $this->redisStore();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        } finally {
            return true;
        }
    }

    /**
     * @return void
     */
    private function countingFemale(): void
    {
        $this->totalFemale = User::where('gender', self::FEMALE)->count();
    }

    /**
     * @return void
     */
    private function countingMale(): void
    {
        $this->totalMale = User::where('gender', self::MALE)->count();
    }

    /**
     * @return void
     */
    private function redisStore(): void
    {
        Redis::set('male.count', $this->totalMale);
        Redis::set('female.count', $this->totalFemale);
    }
}
