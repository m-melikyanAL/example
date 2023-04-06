<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\CampaignSchedule;
use App\Services\CampaignService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SendScheduledCampaigns extends Command
{
    protected $signature = 'campaigns-schedule:process {schedules?*}';

    protected $description = 'Resolves scheduled campaigns and queues notifications to send';

    public function handle(CampaignService $service): int
    {
        $oneTimeSchedules = $this->getOneTimeSchedules();
        $dailySchedules = $this->getDailySchedules();
        $weeklySchedules = $this->getWeeklySchedules();
        $monthlySchedules = $this->getMonthlySchedules();

        $schedules = $oneTimeSchedules->merge($dailySchedules)
            ->merge($weeklySchedules)
            ->merge($monthlySchedules);

        foreach ($schedules as $schedule) {
            $sendAt = $schedule->frequency === Campaign::FREQUENCY_ONE_TIME
                ? $schedule->scheduled_at
                : now()->setTimeFromTimeString($schedule->time);

            $service->sendScheduledCampaign($schedule->campaign, $sendAt);
        }

        return self::SUCCESS;
    }

    private function getOneTimeSchedules(): Collection
    {
        return $this->getBaseQuery()
            ->where('frequency', Campaign::FREQUENCY_ONE_TIME)
            ->whereDate('scheduled_at', now()->startOfDay())
            ->get();
    }

    private function getDailySchedules(): Collection
    {
        return $this->getBaseQuery()
            ->where('frequency', Campaign::FREQUENCY_DAILY)
            ->get();
    }

    private function getWeeklySchedules(): Collection
    {
        return $this->getBaseQuery()
        ->where('frequency', Campaign::FREQUENCY_WEEKLY)
            ->where('day', now()->dayOfWeekIso)
            ->get();
    }

    private function getMonthlySchedules(): Collection
    {
        $lastDayOfMonth = now()->endOfMonth()->day;

        $scheduleQuery = $this->getBaseQuery()
            ->where('frequency', Campaign::FREQUENCY_MONTHLY);

        $scheduleQuery->where('day', now()->day);

        if (now()->day === $lastDayOfMonth) {
            $scheduleQuery->where('day', '>=', now()->day);
        }

        return $scheduleQuery->get();
    }

    private function getBaseQuery(): Builder
    {
        $baseQuery = CampaignSchedule::with([
            'campaign',
            'campaign.promotion',
            'campaign.promotion.digital_assets',
        ]);

        if ($this->argument('schedules')) {
            $baseQuery->whereIn('id', $this->argument('schedules'));
        }

        return $baseQuery;
    }
}
