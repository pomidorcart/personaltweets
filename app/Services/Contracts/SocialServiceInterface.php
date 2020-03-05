<?php

namespace App\Services\Contracts;

interface SocialServiceInterface {
    // connect to a social media provider and return a client object
    public function socialAuthenticate();

    // Returns a laravel collection of the most recent posted messages by a user, defaults to 10 messages only
    public function getSocialUserTimeline($count=10);
}