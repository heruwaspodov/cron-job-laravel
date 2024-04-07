<?php

namespace App\Services;

use App\Contracts\DefaultServiceInterface;
use App\Models\DailyRecord;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 *
 */
class DailyCalculateService implements DefaultServiceInterface
{
    private const FEMALE = 'female';
    private const MALE = 'male';
    private Carbon $dateStart;
    private Carbon $dateEnd;
    private int $totalMale;
    private int $totalFemale;
    private int $totalAgeMale;
    private int $totalAgeFemale;
    private float $avgAgeMale;
    private float $avgAgeFemale;
    private DailyRecord $result;

    public function __construct()
    {
        $this->dateStart = Carbon::today();
        $this->dateEnd = Carbon::today()->addDay(1)->subSecond();
        $this->totalMale = 0;
        $this->totalFemale = 0;
        $this->totalAgeMale = 0;
        $this->totalAgeFemale = 0;
        $this->avgAgeMale = 0;
        $this->avgAgeFemale = 0;
        $this->result = new DailyRecord();
    }

    /**
     * @return bool
     */
    public function call(): bool
    {
        try {
            $this->screening();
            $this->calculate();
            $this->result->save();
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
    private function screening(): void
    {
        $users = $this->getDataFromDate();

        foreach ($users as $user) {
            if ($user['gender'] == self::MALE) {
                $this->totalMale += 1;
                $this->totalAgeMale += $user['age'];
            } else {
                $this->totalFemale += 1;
                $this->totalAgeFemale += $user['age'];
            }
        }
    }

    /**
     * @return array
     */
    private function getDataFromDate(): array
    {
        return User::select('age', 'gender')
            ->whereBetween('created_at', [$this->dateStart, $this->dateEnd])
            ->get()
            ->toArray();
    }

    /**
     * @return void
     */
    private function calculate(): void
    {
        $this->calculateAverage();
        $this->result->date = $this->dateStart;
        $this->result->male_count = $this->totalMale;
        $this->result->female_count = $this->totalFemale;
        $this->result->male_avg_age = $this->avgAgeMale;
        $this->result->female_avg_age = $this->avgAgeFemale;
    }

    /**
     * @return void
     */
    private function calculateAverage(): void
    {
        $this->avgAgeFemale = $this->totalAgeFemale / (float)$this->totalFemale;
        $this->avgAgeMale = $this->totalAgeMale / (float)$this->totalMale;
    }

}
