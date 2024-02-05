<h1 align="center">Locadora de Veículos</h1>

Este é um sistema de gerenciamento de uma locadora de veículos, desenvolvido utilizando o framework Laravel versão 10. O sistema permite listar, criar, editar e remover usuários, assim como veículos. Além disso, é possível realizar reservas de veículos, com a restrição de que um veículo só pode estar reservado para um usuário por vez. Os usuários podem reservar diversos carros simultaneamente.

## <h2 align="center">Requisitos Técnicos</h2>

O sistema atende aos seguintes requisitos técnicos:

- Armazenamento de nome e CPF dos usuários, data de inserção no banco de dados.
- Armazenamento de modelo, marca, ano e placa do veículo.
- Registro das reservas realizadas.
- Validação de todos os dados inseridos no sistema.
- Criação de um evento que é disparado quando um carro é reservado, registrando a id do usuário e a id do veículo no arquivo de log do Laravel.
- Criação de um Job programado para execução duas vezes por dia, com o método handle vazio.
- Utilização do Laravel Mix para a compilação de dependências.
- Utilização do Bootstrap para a construção do front-end.
- Observância do padrão MVC.
- Tratamento adequado de erros.

## <h2 align="center">Instruções de Instalação</h2>

Siga os passos abaixo para iniciar o projeto:

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/gabrielfarias/locadora-veiculos.git
   cd locadora-veiculos
2. **Instale as dependências do Composer:**
   ```bash
    composer install
3. **Copie o arquivo .env.example para .env e configure o banco de dados:**
   ```bash
    cp .env.example .env
4. **Gere a chave de aplicativo:**
   ```bash
   php artisan key:generate
5. **Execute as migrações para criar as tabelas do banco de dados:**
   ```bash
   php artisan migrate
6. **Execute os seeds para adicionar dados fictícios (opcional):**
   ```bash
   php artisan db:seed

<h2 align="center">Uso do Sistema</h2>

1. **Execute o sistema usando o servidor embutido do Laravel:**
   ```bash
   php artisan serve

2. **Acesse o sistema no navegador em http://localhost:8000**

3. **Explore as funcionalidades do sistema, criando/editando/removendo usuários, veículos e realizando reservas.**

<h2 align="center">Logs</h2>

Os logs do sistema estão disponíveis no arquivo de log do Laravel. Para visualizar os logs:

1. **Execute o sistema usando o servidor embutido do Laravel:**
   ```bash
   tail -f storage/logs/laravel.log

Este sistema é projetado para ser o mais simples possível, concentrando-se nos requisitos técnicos e não na estética das páginas. Caso deseje inserir ou remover dados fictícios para facilitar os testes, utilize as funcionalidades específicas disponíveis no sistema.
