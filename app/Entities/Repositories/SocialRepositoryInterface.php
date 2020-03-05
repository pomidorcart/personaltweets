<?php

namespace App\Entities\Repositories;

interface SocialRepositoryInterface {
    //find all results
    public function findAll();
    //find all results and paginate
    public function findAllPaginated(int $limit = 10, int $page = 1);
} 