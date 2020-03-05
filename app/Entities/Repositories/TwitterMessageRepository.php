<?php

namespace App\Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use App\Entities\Repositories\SocialRepositoryInterface;

class TwitterMessageRepository extends EntityRepository implements SocialRepositoryInterface {

    //sort find all result in descending order by created_at column
    public function findAll()
    {
        return $this->findBy(array(), array('created_at' => 'DESC'));
    }
}