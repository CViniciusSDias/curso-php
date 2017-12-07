<?php
namespace CursoPHP\Controller;

use CursoPHP\Model\Contato;
use CursoPHP\Repository\ContatosRepository;
use CursoPHP\Service\ExtratorDeContatoPorRequest;
use CursoPHP\Service\ManipuladorDeContatos;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContatosController
{
    /**
     * @var ExtratorDeContatoPorRequest
     */
    private $extratorDeContato;
    /**
     * @var ManipuladorDeContatos
     */
    private $manipuladorDeContatos;

    public function __construct(
        ExtratorDeContatoPorRequest $extratorDeContato,
        ManipuladorDeContatos $manipuladorDeContatos
    ) {
        $this->extratorDeContato = $extratorDeContato;
        $this->manipuladorDeContatos = $manipuladorDeContatos;
    }

    public function listarAction(): Response
    {
        $contatos = $this->manipuladorDeContatos->buscarTodos();
        return new JsonResponse($contatos);
    }

    public function novoContatoAction(Request $request): Response
    {
        try {
            /** @var Contato $contato */
            $contato = $this->extratorDeContato->extrair($request->getContent());

            return new JsonResponse(...$this->manipuladorDeContatos->inserir($contato));
        } catch (\TypeError $error) {
            return new JsonResponse(['mensagem' => 'Verifique se o nome do contato foi preenchido.'], 422);
        } catch (\InvalidArgumentException $ex) {
            return new JsonResponse(['mensagem' => $ex->getMessage()], $ex->getCode());
        } catch (\Throwable $ex) {
            return new JsonResponse(['mensagem' => 'Erro inesperado'], 500);
        }
    }

    public function removerContatoAction(Request $request): Response
    {
        try {
            $codigoContato = $this->pegarCodigoContato($request);

            return new JsonResponse(...$this->manipuladorDeContatos->remover($codigoContato));
        } catch (\DomainException $ex) {
            return new JsonResponse(['mensagem' => $ex->getMessage()], $ex->getCode());
        }
    }

    public function atualizarContatoAction(Request $request): Response
    {
        try {
            $codigoContato = $this->pegarCodigoContato($request);
            $contato = $this->extratorDeContato->extrair($request->getContent());

            return new JsonResponse(...$this->manipuladorDeContatos->atualizar($contato, $codigoContato));
        } catch (\TypeError $error) {
            return new JsonResponse(['mensagem' => 'Verifique se o nome do contato foi preenchido.'], 422);
        } catch (\DomainException | \InvalidArgumentException $ex) {
            return new JsonResponse(['mensagem' => $ex->getMessage()], $ex->getCode());
        } catch (\Throwable $ex) {
            return new JsonResponse(['mensagem' => 'Erro inesperado'], 500);
        }
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
