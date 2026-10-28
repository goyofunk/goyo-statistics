<?php
namespace Goyo_Statistics\Service\Admin\Metabox\Metaboxes;

use Goyo_Statistics\Abstracts\BaseMetabox;
use Goyo_Statistics\Components\View;
use Goyo_Statistics\Models\VisitorsModel;

class TopCities extends BaseMetabox
{
    protected $key = 'top-cities';
    protected $context = 'normal';

    public function getName()
    {
        return '인기 도시';
    }

    public function getDescription()
    {
        return '선택한 기간의 도시별 방문자와 조회수입니다.';
    }

    public function getScreen()
    {
        return ['dashboard'];
    }

    public function getOptions()
    {
        return ['datepicker' => true];
    }

    public function getData()
    {
        $args = array_merge($this->getFilters(), [
            'group_by' => ['city'],
            'not_null' => 'visitor.city',
            'per_page' => 5,
            'page' => 1,
        ]);
        $model = new VisitorsModel();
        $data = $model->getVisitorsGeoData($args);

        return View::load('components/tables/geographic-top-cities', [
            'data' => $data,
            'dashboard_widget' => true,
        ], true);
    }

    public function render()
    {
        View::load('metabox/metabox-skeleton', []);
    }
}
