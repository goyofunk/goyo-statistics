<?php
defined('ABSPATH') || exit;
?>
<div class="o-table-wrapper">
    <table width="100%" class="o-table goyostats-new-table goyostats-table-inspect goyostats-new-table__most-visited">
        <thead><tr><th scope="col" class="goyostats-pd-l">페이지</th><th scope="col" class="goyostats-pd-l">조회수</th></tr></thead>
        <tbody>
        <?php if (empty($data)) : ?>
            <tr><td colspan="2">이 기간에 대한 데이터가 없습니다.</td></tr>
        <?php else : foreach ($data as $item) : $page = ['title' => $item->title, 'link' => $item->link]; ?>
            <tr>
                <td class="goyostats-pd-l">
                    <?php if (!empty($page['title']) && !empty($page['link'])) : ?>
                        <a title="<?php echo esc_attr($page['title']); ?>" class="goyostats-table-ellipsis--name" href="<?php echo esc_url($page['link']); ?>"><span><?php echo esc_html($page['title']); ?></span></a>
                    <?php else : ?>—<?php endif; ?>
                </td>
                <td class="goyostats-pd-l"><span><?php echo esc_html(number_format_i18n($item->views)); ?></span></td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>
