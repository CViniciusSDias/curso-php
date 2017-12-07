<?php
namespace CursoPHP\Controller;

use CursoPHP\Model\Contato;
use CursoPHP\Repository\ContatosRepository;
use CursoPHP\Service\ExtratorDeContatoPorRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContatosController
{
    /**
     * @var ContatosRepository
     */
    private $contatosRepository;
    /** @var ExtratorDeContatoPorRequest */
    private $extratorDeContato;

    public function __construct(ContatosRepository $contatosRepository, ExtratorDeContatoPorRequest $extratorDeContato)
    {
        $this->contatosRepository = $contatosRepository;
        $this->extratorDeContato = $extratorDeContato;
    }

    public function listarAction(): Response
    {
        $contatos = $this->contatosRepository->buscarTodos();
        return new JsonResponse($contatos);
    }

    public function novoContatoAction(Request $request): Response
    {
        try {
            /** @var Contato $contato */
            $contato = $this->extratorDeContato->extrair($request->getContent());

            if (!$this->contatosRepository->inserir($contato)) {
                return new JsonResponse(['mensagem' => 'Erro ao inserir contato'], 422);
            }
        } catch (\TypeError $error) {
            return new JsonResponse(['mensagem' => 'Verifique se o nome do contato foi preenchido.'], 422);
        } catch (\InvalidArgumentException $ex) {
            return new JsonResponse(['mensagem' => $ex->getMessage()], $ex->getCode());
        } catch (\Throwable $ex) {
            return new JsonResponse(['mensagem' => 'Erro inesperado'], 500);
        }

        return new JsonResponse(['mensagem' => 'Contato inserido com sucesso']);
    }

    public function removerContatoAction(Request $request): Response
    {
        try {
            $codigoContato = $this->pegarCodigoContato($request);

            if (!$this->contatosRepository->remover($codigoContato)) {
                return new JsonResponse(['mensagem' => 'Erro ao remover contato.', 400]);
            }
        } catch (\DomainException $ex) {
            return new JsonResponse(['mensagem' => $ex->getMessage()], $ex->getCode());
        }

        return new JsonResponse(['mensagem' => 'Contato removido com sucesso']);
    }

    public function atualizarContatoAction(Request $request): Response
    {
        try {
            $codigoContato = $this->pegarCodigoContato($request);
            $contato = $this->extratorDeContato->extrair($request->getContent());

            if (!$this->contatosRepository->atualizar($codigoContato, $contato)) {
                return new JsonResponse(['mensagem' => 'Erro ao atualizar contato'], 400);
            }
        } catch (\DomainException $ex) {
            return new JsonResponse(['mensagem' => $ex->getMessage()], $ex->getCode());
        }

        return new JsonResponse(['mensagem' => 'Contato atualizado com sucesso']);
    }

    private function pegarCodigoContato(Request $request): int
    {
        $codigoContato = $request->attributes->get('codigoContato');
        $codigoContato = filter_var($codigoContato, FILTER_VALIDATE_INT);

        if ($codigoContato === false) {
            throw new \DomainException(['mensagem' => 'Código de contato inválido.'], 400);
        }

        return $codigoContato;
    }
}
