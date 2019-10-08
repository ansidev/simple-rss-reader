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
        'du-lich' => 'Du lịch',
        'goc-nhin' => 'Góc nhìn',
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
        'news' => 'Tin tức',
        'xa-hoi' => 'Xã hội'
    ];

    /**
     * @param \SimpleXMLElement $item
     * @return array
     */
    protected function extractCategoryData(\SimpleXMLElement $item): array
    {
        $link = $item->link;
        $linkParts = explode('/', $link);
        if (count($linkParts) < 2) {
            return ['Uncategorized', 'uncategorized'];
        }
        $categorySlug = $linkParts[count($linkParts) - 2];
        $categoryName = $this->categoryMap[$categorySlug] ?? $categorySlug;

        return [$categoryName, $categorySlug];
    }

    protected function getContent(\SimpleXMLElement $item)
    {
        return $item->description;
    }
}
