Instale as dependências usando o Composer

    composer install

Copie o arquivo .env.example e faça as alterações necessários nas configurações no arquivo .env

    cp .env.example .env

Gere uma nova chave de aplicação

    php artisan key:generate

Gere uma nova chave secreta de autenticação JWT

    php artisan jwt:secret

Rode as migrations para criar as tabelas no banco de dados(**Necessário configurar as informações de conexão com o banco no arquivo .env antes de rodar esse comando**)

    php artisan migrate

Rode os seeders para criar os registros padrões

    php artisan db:seed

Inicie o servidor local

    php artisan serve

Agora sua aplicação está disponível no endereço http://localhost:8000
