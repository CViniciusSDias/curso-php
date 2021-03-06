<?php
namespace CursoPHP\Repository;

use CursoPHP\Model\Contato;

class ContatosRepository
{
    /** @var \PDO */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /** @return Contato[] */
    public function buscarTodos(): array
    {
        $stm = $this->pdo->query('SELECT * FROM contatos ORDER BY nome');

        return $stm->fetchAll(\PDO::FETCH_CLASS, Contato::class);
    }

    public function inserir(Contato $contato): bool
    {
        $sql = 'INSERT INTO contatos (nome, email, telefone) VALUES (:nome, :email, :telefone);';
        $stm = $this->pdo->prepare($sql);
        $stm->bindValue(':nome', $contato->getNome());
        $stm->bindValue(':email', $contato->getEmail());
        $stm->bindValue(':telefone', $contato->getTelefone());

        return $stm->execute();
    }

    public function remover(int $contatoId): bool
    {
        $sql = 'DELETE FROM contatos WHERE id = ?';
        $stm = $this->pdo->prepare($sql);
        $stm->bindValue(1, $contatoId, \PDO::PARAM_INT);

        return $stm->execute();
    }

    public function atualizar(int $codigoContato, Contato $contato): bool
    {
        $sql = 'UPDATE contatos SET nome = :nome, email = :email, telefone = :telefone WHERE id = :id;';
        $stm = $this->pdo->prepare($sql);
        $stm->bindValue(':nome', $contato->getNome());
        $stm->bindValue(':email', $contato->getEmail());
        $stm->bindValue(':telefone', $contato->getTelefone());
        $stm->bindValue(':id', $codigoContato, \PDO::PARAM_INT);

        return $stm->execute();
    }
}
