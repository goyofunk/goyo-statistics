<?php

namespace Goyo_Statistics\Service\Charts\DataProvider;

use GOYO_STATISTICS\Admin_Template;
use GOYO_STATISTICS\Country;
use Goyo_Statistics\Decorators\VisitorDecorator;
use Goyo_Statistics\Models\VisitorsModel;
use Goyo_Statistics\Service\Analytics\DeviceDetection\DeviceHelper;
use Goyo_Statistics\Service\Charts\AbstractChartDataProvider;
use Goyo_Statistics\Service\Charts\Traits\BarChartResponseTrait;
use GOYO_STATISTICS\Helper;

class CountryChartDataProvider extends AbstractChartDataProvider
{
    use BarChartResponseTrait;

    protected $visitorsModel;

    public function __construct($args)
    {
        parent::__construct($args);

        $this->args = array_merge($this->args, [
            'not_null'  => 'location',
            'order_by'  => 'visitors',
            'page'      => false,
            'per_page'  => false
        ]);

        $this->visitorsModel = new VisitorsModel();
    }


    public function getData()
    {
        $this->initChartData();

        $data = $this->visitorsModel->getVisitorsGeoData($this->args);
        $data = $this->parseData($data);

        $this->setChartLabels($data['labels']);
        $this->setChartData($data['visitors']);
        $this->setChartIcons($data['icons']);
        $this->setChartPercentages($data['percentages']);

        return $this->getChartData();
    }

    protected function parseData($data)
    {
        $parsedData = [
            'labels'      => [],
            'icons'       => [],
            'visitors'    => [],
            'percentages' => [],
        ];

        if (is_array($data) && !empty($data)) {
            $visitors = intval(array_sum(array_column($data, 'visitors')));
            $topData  = array_slice($data, 0, 5);

            foreach ($topData as $item) {
                $parsedData['labels'][]      = Country::getName($item->country);
                $parsedData['icons'][]       = Country::flag($item->country);
                $parsedData['visitors'][]    = intval($item->visitors);
                $parsedData['percentages'][] = Helper::calculatePercentage(intval($item->visitors), $visitors);
            }
        }

        return $parsedData;
    }
}
