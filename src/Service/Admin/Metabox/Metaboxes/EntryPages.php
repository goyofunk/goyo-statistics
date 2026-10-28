<?php
namespace Goyo_Statistics\Service\Admin\Metabox\Metaboxes;

use Goyo_Statistics\Abstracts\BaseMetabox;
use Goyo_Statistics\Components\View;
use GOYO_STATISTICS\DB;
use GOYO_STATISTICS\Pages;
use GOYO_STATISTICS\TimeZone;

class EntryPages extends BaseMetabox
{
    protected $key = 'entry-pages';
    protected $context = 'side';

    public function getName() { return '최근에 본 페이지'; }
    public function getDescription() { return '마지막으로 조회된 페이지 순서입니다. 조회수는 최근 30일 합계입니다.'; }
    public function getOptions() { return []; }
    public function getData()
    {
        global $wpdb;
        $pages = DB::table('pages');
        $relationships = DB::table('visitor_relationships');
        $since = TimeZone::getTimeAgo(30);
        $data = $wpdb->get_results($wpdb->prepare(
            "SELECT p.id, p.type, p.uri, SUM(p.views) AS views, MAX(recent.last_seen) AS last_seen
            FROM (SELECT page_id, id, type, uri, SUM(count) AS views
                  FROM {$pages} WHERE date >= %s GROUP BY page_id, id, type, uri) p
            LEFT JOIN (SELECT page_id, MAX(date) AS last_seen FROM {$relationships}
                        WHERE date >= %s GROUP BY page_id) recent ON recent.page_id = p.page_id
            GROUP BY p.id, p.type, p.uri
            HAVING last_seen IS NOT NULL
            ORDER BY last_seen DESC, p.id DESC, p.uri ASC LIMIT 20",
            $since, $since
        ));
        foreach ($data as $item) {
            $page = Pages::get_page_info($item->id, $item->type, $item->uri);
            $item->title = $page['title'];
            $item->link = $page['link'];
        }
        return View::load('metabox/entry-pages', ['data' => $data], true);
    }
    public function render() { echo $this->getData(); }
}
