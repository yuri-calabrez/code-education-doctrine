<?php
/**
 * Created by PhpStorm.
 * User: Yuri
 * Date: 20/06/2016
 * Time: 16:47
 */

namespace Code\Sistema\Entity;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ClienteRepository extends EntityRepository{

    //QueryBuilder
    public function getClientesOrdenados(){
        return $this
            ->createQueryBuilder("c")
            ->orderBy("c.nome", "ASC")
            ->getQuery()
            ->getResult();
    }

    //DQL
    public function getClientesDesc(){
        $dql = "SELECT c FROM Code\Sistema\Entity\Cliente c ORDER BY c.nome DESC";

        return $this->getEntityManager()->createQuery($dql)->getResult();
    }

    public function searchByName($nome){
        $dql = "SELECT c FROM Code\Sistema\Entity\Cliente c WHERE c.nome LIKE :nome";

        return $this
            ->getEntityManager()
            ->createQuery($dql)
            ->setParameter("nome", "%{$nome}%")
            ->getResult();
    }

    public function paginate($page = 1, $limit = 10){
        $dql = "SELECT c FROM Code\Sistema\Entity\Cliente c ORDER BY c.nome";

        $qry = $this->getEntityManager()->createQuery($dql)->setFirstResult($limit * ($page - 1))->setMaxResults($limit);

        $paginator = new Paginator($qry);

        foreach ($paginator as $clientes){
            $data[] = $clientes->getNome();
        }

        return $data;
    }
}