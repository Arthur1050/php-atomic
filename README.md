# Ambiente de Desenvolvimento PHP 8.4 com Devcontainer

Este é um ambiente de desenvolvimento local configurado com PHP-FPM 8.4 e Nginx usando devcontainer.

## Pré-requisitos

- [Docker](https://www.docker.com/products/docker-desktop)
- [Visual Studio Code](https://code.visualstudio.com/)
- [Extensão Remote - Containers para VS Code](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers)

## Como usar

1. Clone este repositório
2. Abra a pasta no VS Code
3. Quando solicitado, clique em "Reopen in Container" ou use o comando "Remote-Containers: Reopen in Container"
4. Aguarde a construção do container (isso pode levar alguns minutos na primeira vez)
5. O ambiente estará pronto para uso

## Estrutura

- O diretório raiz do projeto é também o diretório raiz do servidor web
- Todos os arquivos do seu projeto ficam no mesmo nível que a pasta `.devcontainer`

## Serviços

- **PHP-FPM 8.4**: Porta 9000 (interna)
- **Nginx**: Porta 80 (acesse http://localhost)

## Personalizações

Você pode personalizar este ambiente editando os arquivos de configuração na pasta `.devcontainer`.

### Adicionando banco de dados

Se posteriormente precisar adicionar um banco de dados, edite o arquivo `docker-compose.yml` para incluir o serviço desejado (MySQL, PostgreSQL, Oracle, etc.) e atualize o Dockerfile para instalar as extensões PHP necessárias.