<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\Contracts\SocialServiceInterface;
use Illuminate\Support\Collection;
use App\Entities\Social;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use App\Entities\Repositories\SocialRepositoryInterface;

class SocialController extends Controller
{
    private $entityManager;
    private $socialService;

    //inject the Doctrine EntityManager and Social Service Provider
    public function __construct(EntityManagerInterface $entityManager, SocialServiceInterface $socialService)
    {
        $this->entityManager = $entityManager;
        $this->socialService = $socialService;
        $socialService->socialAuthenticate();        
    }

    //fetch records from database
    public function index(SocialRepositoryInterface $social){
        $messages = $social->findAll();
        dd($messages);
        return view('messages', [
            'messages' => $messages
        ]);
    }

    //fetch social messages from social provider and save into db
    public function saveUserTimeLine(){
        $messages = $this->socialService->getSocialUserTimeline()->toArray();
        
        foreach($messages as $message){
            $msg = new Social();
            $msg->setId($message['id']);
            $msg->setSocialTXT($message['social_txt']);
            $msg->setUserId($message['user_id']);
            $msg->setUserScreenName($message['user_screen_name']);
            
            //create DateTime object
            $created_at = new DateTime($message['created_at']);
            $created_at->setTimezone(new DateTimeZone('Europe/London'));

            $msg->setCreatedAt($created_at);
            
            //create or update
            $this->entityManager->merge($msg);
            $this->entityManager->flush();
        }

        return 200;
    }
}
