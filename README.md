# Curso - O PHP como deveria ser

Este repositório contem o código do exemplo utilizado no curso "O PHP como deveria ser",
ministrado no dia 09/12 por Vinícius Dias na FAETERJ - Petrópolis

## SetUp

### Baixar o projeto

Para testar o projeto, você deve, inicialmente clonar o mesmo, utilizando git, ou baixá-lo através do GitHub.

#### Clonar

`git clone https://github.com/CViniciusSDias/curso-php.git` 

### Instalar dependências

Após ter o projeto em sua máquina, é necessário instalar as dependências do mesmo. Para isso, utilize o
[Composer](http://getcomposer.org/).

Entre na pasta do projeto e digite:

`composer install`

### Criar o banco de dados (SQLite)

Para efeitos de simplicidade, este projeto utiliza um banco de dados SQLite.

Após realizar as etapas anteriores, deve-se criar o banco de dados. Para isso, siga as seguintes etapas:

- Instale o cliente [SQLite](http://sqlite.org/)
- Entre na pasta var/data do projeto
- Crie, com o SQLite, o arquivo contatos.sqlite
- Execute a seguinte query SQL:

```sql
CREATE TABLE contatos (
   id INTEGER PRIMARY KEY,
   nome TEXT NOT NULL,
   email TEXT,
   telefone TEXT
);
```

### Inicializar o servidor integrado PHP

Tendo realizadas todas as etapas anteriores, é hora de iniciar o servidor integrado do PHP para testar a aplicação.

Para isso, na pasta raiz do projeto, digite:

`php -S localhost:8000 -t public/ index.php`

## Endpoints

Agora que o projeto está configurado e pronto para testarmos, realize as seguintes requisições:

- _GET_: http://localhost:8000/contatos
    - Listar todos os contatos
- _POST_: http://localhost:8000/contatos*
    - Inserir um novo contato
- _DELETE_: http://localhost:8000/contatos/{codigoContato}
    - Remover um contato, passando seu código na URL
- _PUT_: http://localhost:8000/contatos/{codigoContato}*
    - Atualizar (completamente) um contato, passando seu código na URL

\* Estes endpoints requerem o seguinte json no payload:
```json
{
    "nome": "Contato Teste",
    "telefone": "99000000000",
    "email": "email@teste.com"
}
```

## Contato

Para dúvidas, sugestões, elogios e doações de cerveja:
- carlosv775@gmail.com
- [LinkedIn](https://www.linkedin.com/in/vinícius-dias/)