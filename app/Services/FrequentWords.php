<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use stdClass;

class FrequentWords
{
    public $frequent_words;
    private $common_words;


    public function __construct()
    {
        $this->readCommonWords(); //->scanFeed()->setFrequentWords();
        $this->frequent_words = new \stdClass();
    }


    private function readCommonWords()
    {
        $file = Storage::disk('local')->get('commonwords.txt');
        // $file = file($url);
        // dd($url);
        // read file to property
        $this->common_words = explode(' ', $file);;
        // dd($this->common_words);
        return $this;
    }


    public function scanFeed($feed)
    {
        // dd($feed->entry[10]);
        for ($i=0; $i <= count($feed->entry); $i++) {
            // dd($feed->entry[$i]->title);
            if (isset($feed->entry[$i]->title)) {

                $this->extractWords($feed->entry[$i]->title);

                $this->extractWords($feed->entry[$i]->summary);
            } //else dd($feed->entry[$i]);
        }
        // foreach ($feed->entry as $k => $v) {
        //     dd($v[1]);
        //     if ($k == 'title' || $k == 'summary') {


        //     }
        // }
        return $this;
    }


    private function extractWords($text)
    {
        $no_html = strip_tags($text);

        $no_characters = preg_replace('/[^A-Za-z0-9 ]/', '', $no_html);

        $text_array = explode(' ', $no_characters);

        $no_common_words = array_diff($text_array, $this->common_words);

        $this->countWords($no_common_words);
    }


    private function countWords($text_array)
    {
        // dd($this->frequent_words);
        foreach ($text_array as $word) {

            if ($word == ' ' || $word == '') continue;

            $word = strtolower($word);

            if (!isset($this->frequent_words->$word)) {
                // dd($this->frequent_words);
                $this->frequent_words->$word = 1;

            } else {

                $this->frequent_words->$word += 1;
            }
        }
        // dd($this->frequent_words);
    }


    static function cmp_obj($a, $b)
    {
        if ($a == $b) {
            return 0;
        }
        return ($a > $b) ? +1 : -1;
    }
}