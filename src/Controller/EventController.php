<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\EventSearchType;
use App\Form\Model\EventSearch;
use App\Service\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/events', name:'events')]
    public function index(Request $request, EventService $eventService): Response
    {
        $eventSearch = new EventSearch();
        $eventForm = $this->createForm(EventSearchType::class, $eventSearch);
        $eventForm->handleRequest($request);

        $events = [];

        if($eventForm->isSubmitted() && $eventForm->isValid()){
            $city = $eventForm->get('city')->getData();
            $date = $eventForm->get('date')->getData();
            $data = json_decode($eventService->search($city, $date));
            $events = $data->records;
            dump($events);
        }

        $response =new Response();
        $response->setStatusCode(302);

        return $this->render('event/index.html.twig', ['eventForm'=>$eventForm, 'events'=>$events], $response);
    }

}
