**Introdução**

A aplicação cattle-api é uma API que possui a finalidade de gerenciar os bovinos de uma fazenda,
e ela possui as funcionalidades de cadastrar o animal, listar os animais cadastrados, pesquisar por
um animal específico pelo id ou pelo código de identificação dele, de editar as informações de um animal,
excluir um animal específico, e abater um animal (que esteja vivo). Para utilizar as funcionalidades
do sistema é necessário ter uma conta registrada e estar autenticado, pois caso contrário não será
possível utilizar as funcionalidades mencionadas acima.


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

**Requisitos para executar a aplicação**

- Possuir o php instalado (recomendo que esteja na versão 7.4.*)
- Possuir o gerenciador de pacotes composer (recomendo que esteja na versão 2.5.*)


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

**Como executar a aplicação no seu computador: passo a passo**

- 1°- Acesse o diretório do projeto, ou em outras palavras, acesse a pasta "cattle-api"

- 2°- Copie e cole a pasta ".env.example" e remova o ".example" da cópia

- 3°- rode o comando "composer install" para instalar as dependências do projeto

- 4°- rode o comando php artisan key:generate para gerar a chave de criptografia

- 5°- crie uma conexão no banco de dados mysql (versão 5.7) com as configurações do .env (que se encontram
abaixo do comentário "# configuracoes db" e as variáveis começam com "DB_") e coloque ela para rodar

OBS: caso tenha o docker instalado pode pular o passo 5° e rodar apenas o comando "docker-compose up -d"
no diretório raíz do projeto

- 6°- rode o comando "php artisan serve" para iniciar o projeto

- 7°- rode o comando "php artisan migrate" para executar as migrations


Observação: Ao executar o passo a passo todo acima, na próxima vez que for rodar a aplicação não será
rodar o comando "composer install" e nem o comando "php artisan key:generate"

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

**Arquivo para teste da aplicação no postman**

Na raiz deste projeto existe um arquivo chamado cattle_postman_collection.json que pode ser importado
no postman, ele já vai conter uma collection com todas as requisições da api já configuradas e com
parâmetros definidos para que o usuário já possa testar a aplicação sem precisar configurar tudo do
zero. No entanto, é possível encontrar também no swagger os endpoints e os parâmetros de header
e body que cada endpoint utiliza, além dos próprios endpoints que a aplicação possui
