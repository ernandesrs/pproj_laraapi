# LARA API
Lara Api é uma API RESTful construída com Laravel 11 para fins de estudos na criação de APIs com Laravel, ela possui um conjunto de endpoints para:

    - Autenticação: Login, registro, verificação de conta e recuperação de senha.
    - Gerenciamento de perfil: Atualização de informações de conta, mudança de senha, etc.
    - Controle de acesso: controle de acesso a áreas logadas baseadas em cargos, onde cada cargo possui suas permissões para executar ações sobre recursos da aplicação.

Nesta API foram utilizas o Sanctum para autenticação e o pacote Laravel Permission para garantir a segurança das operações na aplicação.

# DOCUMENTAÇÃO
A documentação da API foi foi com o Postman, e pode ser encontrada (clicando aqui)[https:(https://documenter.getpostman.com/view/15369452/2sA3s7iopJ)].

# REQUISITOS
    - PHP 8.1 ou superior
    - Composer 2.4.1 ou superior
    - Node v18.8.0 ou superior

# INSTALAÇÃO E EXECUÇÃO
1. Clone o código fonte:
> git clone https://github.com/ernandesrs/pproj_laraapi

2. Acesse a pasta:
> cd pproj_laraapi

3. Faça uma cópia do arquivo `_.env.example_`, o renomeie para `_.env_` e faça as seguintes alterações obrigatórias:
    1. Adicione os dados de acesso ao banco de dados;
    2. Adicione os dados SMTP para envio de e-mails;
    3. Garanta que `_FILESYSTEM_DISK_` seja `public`;

4. Instale as dependências:
> composer install
> npm install

5. Rode os seguintes comandos para gerar a chave da aplicação e criação do link simbólico a pasta pública de arquivos, respectivamente:
> php artisan key:generate
> php artisan storage:link

6. Execute os _migrations_ para gerar as tabelas no banco de dados:
> php artisan migrate

7. Se quiser, execute o comando abaixo para popular a tabela com dados fakes para testes:
> php artisan db:seed

O comando acima irá criar diversos usuários, 2 cargos iniciais, registrar permissões e criar um usuário `super admin` e um usuário `admin`, os dados de login são:
###### Super Admin
    - Email: super@mail.com
    - Senha: password

###### Admin
    - Email: admin@mail.com
    - Senha: password

# TESTANDO
Após os passos acima, você pode acessar `http://127.0.0.1:8000/api/test` para testar. A resposta será `{"success":true}`.
