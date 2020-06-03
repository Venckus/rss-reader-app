<?php

namespace App\Services;


class RSSFeed
{

    public $common_words;
    public $words;
    public $posts;


    public function __construct()
    {
        $this->loadPosts();
        $this->words = new FrequentWords();
    }


    public function loadPosts()
    {
        $xml_content = 'https://www.theregister.com/software/headlines.atom';
        
        $this->posts = simplexml_load_file($xml_content);

        return $this;
    }


    public function findFrequentWords()
    {
        $this->words->scanFeed($this->posts);
    }
}