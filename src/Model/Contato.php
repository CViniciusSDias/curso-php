<?php
namespace CursoPHP\Model;

class Contato implements \JsonSerializable
{
    private $id;
    private $nome;
    private $email;
    private $telefone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): Contato
    {
        $this->nome = $nome;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): Contato
    {
        $this->email = $email;
        return $this;
    }

    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    public function setTelefone(string $telefone): Contato
    {
        $this->telefone = $telefone;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}