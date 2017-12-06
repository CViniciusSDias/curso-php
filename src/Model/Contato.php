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
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('E-mail inválido', 422);
        }

        $this->email = $email;
        return $this;
    }

    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    public function setTelefone(string $telefone): Contato
    {
        if (!filter_var($telefone, FILTER_VALIDATE_INT)) {
            throw new \InvalidArgumentException('Formato de telefone inválido. Digite apenas números', 422);
        }

        $this->telefone = $telefone;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}