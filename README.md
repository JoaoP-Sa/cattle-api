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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

**Usando a aplicação**

Normalmente ao iniciar a aplicação ela rodará na porta 8000 do localhost, embora possa acontecer
dela rodar em outras portas caso essa já esteja ocupada.

Não é recomendado que tente usar a aplicação usando o ip 127.0.0.1 caso vá tentar utilizar algum
endpoint pelo navegador devido a problemas no CORS, no entanto esse tipo de problema não ocorre
utilizando o postman ou qualquer outra aplicação que faz requisições HTTP, como o insomnia por exemplo.

Temos 2 principais endpoints em nossa aplicação, que são:

http://localhost:8000/api
http://localhost:8000/api/animal

e todos os outros endpoints são derivados de algum desses 2. Dentro da aplicação é possível
encontrar todos os endpoints existentes em: http://localhost:8000/api/documentation, ela mostra
os endpoints existentes, os parâmetros ou query params esperados, e o método solicitado (get, post,
put, delete).

Para utilizar qualquer funcionalidade do sistema é necessário criar uma conta e fazer a autenticação
nela nos endpoints abaixo:

Registro: http://127.0.0.1:8000/api/register
Autenticação: http://127.0.0.1:8000/api/login

As rotas acima são as únicas que não necessitam de autenticação para serem usadas. Após feita a 
autenticação será possível utilizar todos os outros endpoints do sistema, contanto que o token 
fornecido na autenticação seja utilizado no Authorization dentro do header de todas as outras requisições.

OBS: sempre que for inserir o token deve-se colocar o "Bearer" antes de inserir a chave fornecida.
