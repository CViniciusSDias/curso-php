<?php
namespace CursoPHP\Service;

use CursoPHP\Model\Contato;
use CursoPHP\Repository\ContatosRepository;

class ManipuladorDeContatos
{
    /**
     * @var ContatosRepository
     */
    private $contatosRepository;

    public function __construct(ContatosRepository $contatosRepository)
    {
        $this->contatosRepository = $contatosRepository;
    }

    public function buscarTodos(): array
    {
        return $this->contatosRepository->buscarTodos();
    }

    public function inserir(Contato $contato): array
    {
        if (!$this->contatosRepository->inserir($contato)) {
            return [['mensagem' => 'Erro ao inserir contato'], 422];
        }

        return [['mensagem' => 'Contato inserido com sucesso']];
    }

    public function remover(int $codigoContato): array
    {
        if (!$this->contatosRepository->remover($codigoContato)) {
            return ['mensagem' => 'Erro ao remover contato.', 400];
        }

        return [['mensagem' => 'Contato removido com sucesso']];
    }

    public function atualizar(Contato $contato, int $codigoContato): array
    {
        if (!$this->contatosRepository->atualizar($codigoContato, $contato)) {
            return [['mensagem' => 'Erro ao atualizar contato'], 400];
        }

        return [['mensagem' => 'Contato atualizado com sucesso']];
    }
}
