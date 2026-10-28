<?php
namespace Goyo_Statistics\Service\Admin\Metabox\Metaboxes;

use Goyo_Statistics\Components\View;
use Goyo_Statistics\Abstracts\BaseMetabox;
use Goyo_Statistics\Components\DateRange;

class TrafficOverview extends BaseMetabox
{
    protected $key = 'quickstats';
    protected $context = 'normal';

    public function getName()
    {
        return '통계';
    }

    public function getDescription()
    {
        return esc_html__('', 'goyo-statistics');
    }

    public function getScreen()
    {
        return ['dashboard'];
    }

    public function getData()
    {
        $chartData = $this->dataProvider->getTrafficChartData(['date' => DateRange::get('7days', true)]);
        $data      = $this->dataProvider->getTrafficOverviewData();

        $output = View::load('metabox/traffic-overview', ['data' => $data], true);

        return [
            'data'   => $chartData,
            'output' => $output
        ];
    }

    public function render()
    {
        View::load('metabox/metabox-skeleton', []);
    }
}