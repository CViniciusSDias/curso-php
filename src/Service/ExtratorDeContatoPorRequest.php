<?php
namespace CursoPHP\Service;

use CursoPHP\Model\Contato;

class ExtratorDeContatoPorRequest
{
    /** @var \JsonMapper */
    private $jsonMapper;

    public function __construct(\JsonMapper $jsonMapper)
    {
        $this->jsonMapper = $jsonMapper;
    }

    public function extrair(string $jsonCorpoRequest): Contato
    {
        $corpoEmJson = json_decode($jsonCorpoRequest);

        return $this->jsonMapper->map($corpoEmJson, new Contato());
    }
}
