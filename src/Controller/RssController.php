<?php
/**
 * RssController.php
 * Created by PhpStorm.
 * Author: Maciej Kowal <kontakt@maciejkowal.pl>
 * Date: 11/5/19
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Handlers\ExtractWordsHandler;

class RssController extends AbstractController
{

    /**
     * @Route("/", name="app_rss")
     * @param ExtractWordsHandler $extractWordsHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function rss(ExtractWordsHandler $extractWordsHandler)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $rss = simplexml_load_file( 'https://www.theregister.co.uk/software/headlines.atom');

        $topWords = $extractWordsHandler->extractTopWords($rss->entry);

        return $this->render('rss.html.twig', [
            'rss' => $rss->entry,
            'words' => $topWords
        ]);
    }

}