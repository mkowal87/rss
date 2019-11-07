<?php
/**
 * ExtractWordsHandlerTest.php
 * Created by PhpStorm.
 * Author: Maciej Kowal <kontakt@maciejkowal.pl>
 * Date: 11/7/19
 */
namespace App\Tests\Handlers;

use App\Handlers\ExtractWordsHandler;
use PHPUnit\Framework\TestCase;

class ExtractWordsHandlerTest extends TestCase
{

    public function testExtractTopWords()
    {
        $xmlString = '<?xml version="1.0" encoding="UTF-8"?>
            <root>
                <entry>
                    <summary>
                    10 index index index index index index index index index index
                    </summary>
                </entry>
                <entry>
                    <summary>
                    9 string string string string string string string string string
                    </summary>
                </entry>
                <entry>
                    <summary>
                    8 broken broken broken broken broken broken broken broken 
                    </summary>
                </entry>
                <entry>
                    <summary>
                    7 define define define define define define define
                    </summary>
                </entry>
                <entry>
                    <summary>
                    6 value value value value value value
                    </summary>
                </entry>
                <entry>
                    <summary>
                    5 comma comma comma comma comma
                    </summary>
                </entry>
                <entry>
                    <summary>
                    4 root root root root
                    </summary>
                </entry>
                <entry>
                    <summary>
                    3 omitted omitted omitted
                    </summary>
                </entry>
                <entry>
                    <summary>
                    2 auto auto
                    </summary>
                </entry>
                <entry>
                    <summary>
                    1 sting
                    </summary>
                </entry>
                <entry>
                    <summary>
                        some words to be not used, like then, the, why, on
                    </summary>
                </entry>
            </root>';

        
        $testObject = new \SimpleXMLElement($xmlString);

        $extractWordHandler = new ExtractWordsHandler();
        $extract = $extractWordHandler->extractTopWords($testObject);

        $expected = array('index' => 10, 'string'=> 9, 'broken'=> 8, 'define'=> 7, 'value'=> 6,
                        'comma'=> 5, 'root'=> 4, 'omitted'=> 3, 'auto'=> 2, 'sting'=> 1);

        $this->assertEquals($extract, $expected);
    }
}
