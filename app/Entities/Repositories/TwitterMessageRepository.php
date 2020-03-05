<?php

namespace App\Entities\Repositories;

use Doctrine\ORM\EntityRepository;
use  Doctrine\ORM\Pagination\PaginatesFromRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;
use App\Entities\Repositories\SocialRepositoryInterface;

class TwitterMessageRepository extends EntityRepository implements SocialRepositoryInterface {

    use PaginatesFromParams;

    //sort find all result in descending order by created_at column
    public function findAll()
    {
        return $this->findBy(array(), array('created_at' => 'DESC'));
    }
    
    /**
     * @return Socials[]|LengthAwarePaginator
     * Sort by created_at column and paginate
     */
    public function findAllPaginated(int $limit = 10, int $page = 1): LengthAwarePaginator
    {
        $query = $this->createQueryBuilder('s')
            ->orderBy('s.created_at', 'DESC')
            ->getQuery();

        return $this->paginate($query, $limit, $page);
    }
}