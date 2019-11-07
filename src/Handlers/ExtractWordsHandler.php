<?php
/**
 * ExtractWordsHandler.php
 * Created by PhpStorm.
 * Author: Maciej Kowal <kontakt@maciejkowal.pl>
 * Date: 11/5/19
 */

namespace App\Handlers;


class ExtractWordsHandler
{
    const BLACKLIST = ['the', 'be', 'to', 'of', 'and', 'a', 'in', 'that', 'have', 'i',
        'it', 'for', 'not', 'on', 'with', 'he', 'as', 'you', 'do', 'at',
        'this', 'but', 'his', 'by', 'from', 'they', 'we', 'say', 'her', 'she',
        'or', 'will', 'an', 'my', 'one', 'all', 'would', 'there', 'their', 'what',
        'so', 'up', 'out', 'if', 'about', 'who', 'get', 'which', 'go', 'when'];

    /**
     * @param $entries
     * @return array
     */
    public function extractTopWords(\SimpleXMLElement $entries) : array
    {
        $string = $this->reduceSigns($this->getSummariesString($entries));
        $matchWords = $this->getIndividualWords($string);
        $keywords = $this->getKeyWords($matchWords);

        return $keywords;
    }

    /**
     * @param $string
     * @return string
     */
    protected function reduceSigns(string $string) : string
    {
        $string = preg_replace('/ss+/i', '', $string);
        $string = strip_tags($string);
        $string = trim($string);
        $string = preg_replace('/[^a-zA-Z -]/', '', $string);
        $string = strtolower($string);
        return $string;
    }

    /**
     * @param $entries
     * @return string
     */
    protected function getSummariesString($entries) : string
    {
        $string = '';
        foreach ($entries as $entry){
            $string .= $entry->summary;
        }
        return $string;
    }
    /**
     * @param string $string
     * @return array
     */
    protected function getIndividualWords(string $string) : array
    {
        preg_match_all('/\b.*?\b/i', $string, $matchWords);
        $matchWords = $matchWords[0];

        foreach ($matchWords as $key => $item) {
            if ($item == '' || in_array(strtolower($item), self::BLACKLIST) || strlen($item) <= 3) {
                unset($matchWords[$key]);
            }
        }
        return $matchWords;
    }


    /**
     * @param array $matchWords
     * @param int $limit
     * @return array
     */
    protected function getKeyWords(array $matchWords, int $limit = 10) : array
    {
        $wordCount = str_word_count( implode(" ", $matchWords) , 1);
        $frequency = array_count_values($wordCount);
        arsort($frequency);

        $keywords = array_slice($frequency, 0, $limit);
        return $keywords;
    }


}