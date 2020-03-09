<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\Contracts\SocialServiceInterface;
use App\Entities\Repositories\SocialRepositoryInterface;
use Illuminate\Support\Collection;
use App\Entities\Social;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use App\Exceptions\TwitterAuthException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;

class SocialController extends Controller
{
    private $entityManager;
    private $socialService;
    private $resultPerPage;

    //inject the Doctrine EntityManager and Social Service Provider
    public function __construct(EntityManagerInterface $entityManager, SocialServiceInterface $socialService)
    {
        $this->entityManager = $entityManager;
        $this->socialService = $socialService;
        $socialService->socialAuthenticate();  
        $this->resultPerPage = 10;      
    }

    //fetch records from database, served via Laravel view: /messages
    public function indexView(Request $request, SocialRepositoryInterface $social){
        if (!empty($request->input('page'))) {
            $page = intval((int)$request->input('page'));
        } else {
            $page = 1;
        }

        $messages = $social->findAllPaginated($this->resultPerPage, $page);
       
        return view('social.messages', [
            'messages' => $messages
        ]);
    }

    //fetch records from database, served via api endpoint: api/social
    public function indexApi(Request $request, SocialRepositoryInterface $social){
        if (!empty($request->input('page'))) {
            $page = intval((int)$request->input('page'));
        } else {
            $page = 1;
        }

        $messages = $social->findAll();
        //dd($messages);
        return response(json_encode($messages), 200)
            ->header('Content-Type', 'json');
    }

    //fetch social messages from social provider and save into db
    public function saveUserTimeLine(){
        try {
            $messages = $this->socialService->getSocialUserTimeline()->toArray();
        
        } catch (ClientException $ex){
            if ($ex->hasResponse()) {
                throw new TwitterAuthException(Psr7\str($ex->getResponse()));
            }
        }
        
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

        return response(json_encode(['msg'=>'ssuccess', 'code'=>200]));
    }
}
