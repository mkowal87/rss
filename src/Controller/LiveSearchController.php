<?php
/**
 * LiveSearchController.php
 * Created by PhpStorm.
 * Author: Maciej Kowal <kontakt@maciejkowal.pl>
 * Date: 11/6/19
 */

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class LiveSearchController extends AbstractController
{
    /**
     * @Route("/searchUser", name="ajax_search_user")
     */
    public function searchUserByEmail(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $requestString = $request->get('email');
        $users = $entityManager->getRepository(User::class)->findBy(['email'=>$requestString]);

        if(!$users) {
            $result['text'] = "Email is available";
            $result['status'] = true;
        } else {
            $result['text'] = "Email is not available";
            $result['status'] = false;
        }

        return new Response(json_encode($result));
    }

}