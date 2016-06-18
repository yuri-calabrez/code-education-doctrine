<?php

namespace Code\Sistema\Service;

use Code\Sistema\Entity\Cliente;
use Code\Sistema\Mapper\ClienteMapper;

class ClienteService
{
    
    /**
     * @var Cliente
     */
    private $cliente;
    /**
     * @var ClienteMapper
     */
    private $clienteMapper;

    public function __construct(Cliente $cliente, ClienteMapper $clienteMapper){

        $this->cliente = $cliente;
        $this->clienteMapper = $clienteMapper;
    }

    public function insert(array $data){
        $clienteEntity = $this->cliente;
        $clienteEntity->setNome($data['nome']);
        $clienteEntity->setEmail($data['email']);

        $mapper = $this->clienteMapper;
        $result = $mapper->create($clienteEntity);

        return $result;
    }

    public function update($id, array $data){
        $mapper = $this->clienteMapper;
        $result = $mapper->update($id, $data);

        return $result;
    }

    public function delete($id){
        return $this->clienteMapper->delete($id);
    }
}