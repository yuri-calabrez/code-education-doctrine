<?php

namespace Code\Sistema\Service;

use Code\Sistema\Entity\Cliente;
use Code\Sistema\Entity\ClienteProfile;
use Doctrine\ORM\EntityManager;

class ClienteService{

    private $em;

    public function __construct(EntityManager $em){

        $this->em = $em;
    }

    public function insert(array $data){
        $clienteEntity = new Cliente();
        $clienteEntity->setNome($data['nome']);
        $clienteEntity->setEmail($data['email']);

        if(isset($data['rg']) && isset($data['cpf'])):
            $clienteProfile = new ClienteProfile();
            $clienteProfile->setRg($data['rg']);
            $clienteProfile->setCpf($data['cpf']);

            $this->em->persist($clienteProfile);
            //Faz relacionamento
            $clienteEntity->setProfile($clienteProfile);
        endif;

        $this->em->persist($clienteEntity);
        $this->em->flush();

        return $clienteEntity;
    }

    public function update($id, array $data){
        $cliente = $this->em->getReference("Code\Sistema\Entity\Cliente", $id);

        $cliente->setNome($data['nome']);
        $cliente->setEmail($data['email']);

        $this->em->persist($cliente);
        $this->em->flush();

        return ['nome' => $cliente->getNome()];
    }

    public function fetchAll(){
        $repo = $this->em->getRepository("Code\Sistema\Entity\Cliente");
        return $repo->findAll();
    }

    public function searchByName($name){
        $repo = $this->em->getRepository("Code\Sistema\Entity\Cliente");
        return $repo->searchByName($name);
    }

    public function paginate($page, $limit){
        $repo = $this->em->getRepository("Code\Sistema\Entity\Cliente");
        return $repo->paginate($page, $limit);
    }

    public function find($id){
        $repo = $this->em->getRepository("Code\Sistema\Entity\Cliente");

        /*$ex = $repo->findBy(['nome' => 'Alex']);
        //metodo Magico!
        $ex = $repo->findByNome("Yuri");*/
        return $repo->find($id);
    }

    public function delete($id){
        $cliente = $this->em->getReference("Code\Sistema\Entity\Cliente", $id);
        $this->em->remove($cliente);
        $this->em->flush();
        return true;
    }
}