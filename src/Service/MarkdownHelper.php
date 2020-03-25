<?php


namespace App\Service;


use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;


class MarkdownHelper
{
    private $cache;
    private $markdown;
    private $logger;

    public function __construct(AdapterInterface $cache, MarkdownInterface $markdown, LoggerInterface $markdownLogger)
    {
        $this->cache = $cache;
        $this->markdown = $markdown;
        $this->logger = $markdownLogger;
    }

    public function parse(string $sourceArgument) : string
    {
        if (strpos($sourceArgument, 'solar') !== false){
            $this->logger->info('This article is about the solar system');
        }
        $item = $this->cache->getItem('markdown_'.md5($sourceArgument));
        if (!$item->isHit()) {
            $item->set($this->markdown->transform($sourceArgument));
            $this->cache->save($item);
        }
        return $item->get();
    }
}