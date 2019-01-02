<?php

namespace App\Feed\Processor;

class VNExpressFeedProcessor extends FeedProcessor
{
    private $categoryMap = [
        'the-gioi' => 'Thế giới',
        'thoi-su' => 'Thời sự',
        'suc-khoe' => 'Sức khỏe',
        'kinh-doanh' => 'Kinh doanh',
        'travel-life' => 'Du lịch',
        'infographics' => 'Infographics',
        'doi-song' => 'Đời sống',
        'phap-luat' => 'Pháp luật',
        'industries' => 'Công nghiệp',
        'khoa-hoc' => 'Khoa học',
        'hanh-trinh-khoi-nghiep' => 'Khởi nghiệp',
        'xu-huong' => 'Xu hướng',
        'y-tuong-moi' => 'Ý tưởng mới',
        'giai-tri' => 'Giải trí',
        'bong-da' => 'Bóng đá',
        'the-thao' => 'Thể thao',
        'giao-duc' => 'Giáo dục',
        'so-hoa' => 'Công nghệ',
        'cong-dong' => 'Cộng đồng',
        'oto-xe-may' => 'Ô tô & xe máy',
        'tam-su' => 'Tâm sự',
        'cuoi' => 'Cười',
    ];

    /**
     * @param \SimpleXMLElement $item
     * @return string
     */
    protected function extractCategoryName(\SimpleXMLElement $item): string
    {
        $link = $item->link;
        $linkParts = explode('/', $link);
        $categorySlug = $linkParts[count($linkParts) - 2];
        return $this->categoryMap[$categorySlug] ?? $categorySlug;
    }

    protected function getContent(\SimpleXMLElement $item)
    {
        return $item->description;
    }
}
