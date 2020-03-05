<?php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Illuminate\Support\Collection;
use App\Services\Contracts\SocialServiceInterface;

class TwitterService implements SocialServiceInterface {

    //Twitter API base endpoint
    private $endpoint;
    private $client;
    private $tweet;
    private $tweetCollection;

    public function __construct()
    {
        $this->tweetCollection = collect();
        $this->client = null;
        $this->tweet = null;
        $this->endpoint = "https://api.twitter.com/1.1/";
    }

    public function socialAuthenticate() {
        $defaults = [];

        $stack = HandlerStack::create();
        //twitter only supports Oauth1 at this point
        $oauth = new Oauth1([
            'consumer_key'    => env('TWITTER_CONSUMER_KEY', ''),
            'consumer_secret' => env('TWITTER_CONSUMER_SECRET', ''),
            'token'           => env('TWITTER_ACCESS_TOKEN', ''),
            'token_secret'    => env('TWITTER_ACCESS_TOKEN_SECRET', ''),
        ]);
        $stack->push($oauth);
        $defaults = array_merge($defaults, [
            'base_uri' => $this->endpoint,
            'handler'  => $stack,
            'auth'     => 'oauth',
            'stream'   => true,
        ]);

        $this->client = new Client($defaults);
    }
    
    public function getSocialUserTimeline($count=10) {
        $response = $this->client->get('statuses/user_timeline.json', [
            'query' => [
                'screen_name' => env('TWITTER_SCREEN_NAME', ''),
                'count' => $count
            ],
        ]);
        
        $body = $response->getBody();
        $tweets = json_decode($this->readLine($body), true);

        foreach ($tweets as $tweet) {
            $this->tweet = $tweet;
            $socialText = isset($this->tweet['text']) ? $this->tweet['text'] : 'null';
            $userid = isset($this->tweet['user']['id_str']) ? $this->tweet['user']['id_str'] : 'null';
            $screenName = isset($this->tweet['user']['screen_name']) ? $this->tweet['user']['screen_name'] : 'null';
            $createdAt = isset($this->tweet['created_at']) ? $this->tweet['created_at'] : 'null';
            if (isset($this->tweet['id'])) {
                $this->tweetCollection->push([
                    'id' => $this->tweet['id_str'],
                    'social_txt' => $socialText,
                    'user_id' => $userid,
                    'user_screen_name' => $screenName,
                    'created_at' => $createdAt
                ]);
            }
        }

        return $this->tweetCollection;
    }

    public function readLine($stream, $maxLength = null, $endOfLine = PHP_EOL)
    {
        $buffer    = '';
        $size      = 0;
        $endOfLineLenght = -strlen($endOfLine);
        while (!$stream->eof()) {
            if (false === ($byte = $stream->read(1))) {
                return $buffer;
            }
            $buffer .= $byte;
            // break on new line or when maxLength -1 is reached
            if (++$size == $maxLength || substr($buffer, $endOfLineLenght) === $endOfLine) {
                break;
            }
        }
        return $buffer;
    }
}
