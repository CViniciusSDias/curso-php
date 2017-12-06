<?php
namespace CursoPHP\Controller;

use CursoPHP\Model\Contato;
use CursoPHP\Repository\ContatosRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContatosController
{
    /**
     * @var ContatosRepository
     */
    private $contatosRepository;
    /** @var \JsonMapper */
    private $jsonMapper;

    public function __construct(ContatosRepository $contatosRepository, \JsonMapper $jsonMapper)
    {
        $this->contatosRepository = $contatosRepository;
        $this->jsonMapper = $jsonMapper;
    }

    public function listarAction(): Response
    {
        $contatos = $this->contatosRepository->buscarTodos();
        return new JsonResponse($contatos);
    }

    public function novoContatoAction(Request $request): Response
    {
        $corpoEmJson = json_decode($request->getContent());
        try {
            /** @var Contato $contato */
            $contato = $this->jsonMapper->map($corpoEmJson, new Contato());
        } catch (\Exception $ex) {
            return new JsonResponse(['mensagem' => $ex->getMessage()], $ex->getCode());
        }

        if (!$this->contatosRepository->inserir($contato)) {
            return new JsonResponse(['mensagem' => 'Erro ao inserir contato'], 401);
        }

        return new JsonResponse(['mensagem' => 'Contato inserido com sucesso']);
    }
}
