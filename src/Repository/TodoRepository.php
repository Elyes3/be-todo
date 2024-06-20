<?php

namespace App\Repository;

use App\Entity\Todo;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

/**
 * @extends ServiceEntityRepository<Todo>
 */
class TodoRepository extends DocumentRepository
{
}
