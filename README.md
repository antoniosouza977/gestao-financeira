# Gestão Financeira Pessoal

Este é um projeto de aplicação web para gestão financeira pessoal, desenvolvido com Laravel e Vue.js, e orquestrado com Docker.

## Configuração para Desenvolvimento

Siga os passos abaixo para configurar e rodar o projeto em sua máquina de desenvolvimento.

### Pré-requisitos

Certifique-se de ter os seguintes softwares instalados:

*   **Docker:** Para rodar os serviços da aplicação em contêineres.
*   **Docker Compose:** Para orquestrar os contêineres Docker.

### Primeiros Passos

1.  **Clone o repositório:**

    ```bash
    git clone https://github.com/antoniosouza977/gestao-financeira.git
    cd gestao-financeira
    ```

2.  **Crie o arquivo de variáveis de ambiente:**

    Copie o arquivo de exemplo `.env.example` para `.env`.

    ```bash
    cp .env.example .env
    ```

    O script `start.sh` irá automaticamente configurar as variáveis `VITE_HMR_HOST` e `VITE_HMR_PORT` no seu arquivo `.env` para o IP da sua máquina, o que é essencial para o Hot Module Replacement (HMR) do Vite funcionar corretamente dentro do ambiente Docker.

3.  **Inicie a aplicação com Docker Compose:**

    Execute o script `start.sh`. Este script irá:
    *   Definir as permissões necessárias para os diretórios `storage` e `bootstrap`.
    *   Parar quaisquer contêineres Docker Compose em execução.
    *   Atualizar as variáveis `VITE_HMR_HOST` e `VITE_HMR_PORT` no seu arquivo `.env`.
    *   Construir (se necessário) e iniciar os serviços Docker definidos no `compose.yml` em modo detached.

    ```bash
    ./start.sh
    ```

    Aguarde alguns minutos para que os serviços sejam inicializados e as dependências sejam instaladas dentro dos contêineres.

4.  **Instale as dependências do Composer:**

    Execute o Composer dentro do contêiner PHP para instalar as dependências do Laravel:

    ```bash
    docker compose exec app composer install
    ```

5.  **Gere a chave da aplicação:**

    ```bash
    docker compose exec app php artisan key:generate
    ```

6.  **Execute as migrações do banco de dados:**

    ```bash
    docker compose exec app php artisan migrate
    ```

7.  **Opcional: Popule o banco de dados com dados de exemplo (seed):**

    ```bash
    docker compose exec app php artisan db:seed
    ```

8.  **Instale as dependências do Node.js e compile os assets:**

    Execute o npm dentro do contêiner Node.js para instalar as dependências do frontend e iniciar o servidor de desenvolvimento do Vite:

    ```bash
    docker compose exec node npm install
    docker compose exec node npm run dev
    ```
    Mantenha este comando rodando em um terminal separado para que o HMR funcione.

### Acessando a Aplicação

Após seguir todos os passos, a aplicação estará disponível em seu navegador.

*   **Frontend:** `http://localhost` (ou o IP da sua máquina, dependendo da sua configuração Docker e do `VITE_HMR_HOST`)

### Parando a Aplicação

Para parar todos os serviços Docker da aplicação, execute:

```bash
docker compose down
```
