<?php

namespace Code\Sistema\Mapper;

use Code\Sistema\Entity\Cliente as ClienteEntity;
use Doctrine\ORM\EntityManager;

class ClienteMapper
{

    private $em;

    public function __construct(EntityManager $em){
        $this->em = $em;
    }

    public function create(ClienteEntity $cliente){
        $this->em->persist($cliente);
        $this->em->flush();

        return [
            'success' => true
        ];
    }

    public function update($id, array $data){
        $cli = $this->em->getReference("Code\Sistema\Entity\Cliente", $id);
        $cli->setNome($data['nome']);
        $cli->setEmail( $data['email']);
        $this->em->persist($cli);
        $this->em->flush();

        return [
            'nome' => $cli->getNome(),
            'success' => true
        ];
    }

    public function delete($id){
        $cli = $this->em->getReference("Code\Sistema\Entity\Cliente", $id);
        $this->em->remove($cli);
        $this->em->flush();
        
        return true;
    }


}