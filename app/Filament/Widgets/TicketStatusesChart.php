<?php

namespace App\Filament\Widgets;

use App\Models\TicketStatus;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class TicketStatusesChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'ticketStatusesChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Ticket Statuses';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $ticketStatuses = TicketStatus::select('id', 'name')->withCount(['tickets'])->get();
        return [
            'chart' => [
                'type' => 'pie',
                'height' => 300,
            ],
            'series' => $ticketStatuses->pluck('tickets_count')->toArray(),
            'labels' => $ticketStatuses->pluck('name')->toArray(),
            'legend' => [
                'labels' => [
                    'colors' => '#9ca3af',
                    'fontWeight' => 600,
                ],
            ],
        ];
    }
}
