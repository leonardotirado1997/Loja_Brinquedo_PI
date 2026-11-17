# Toy Mania

Painel administrativo de uma loja de brinquedos e produtos infantis, desenvolvido em PHP e MySQL para o Projeto Integrador 2026.

O sistema permite que funcionários entrem com e-mail e senha e gerenciem a equipe, as categorias e o catálogo de brinquedos, incluindo o envio de várias fotos por produto.

## Requisitos

- PHP 8.0 ou superior, com as extensões `pdo_mysql`, `gd`, `fileinfo` e `mbstring`
- MySQL 8 ou MariaDB 10.4 ou superior
- Apache (o XAMPP já inclui PHP, MySQL e Apache)
- Navegador atualizado

A extensão `exif` é opcional. Quando está ativa, fotos JPEG tiradas pelo celular são giradas para a orientação correta.

## Configurar o banco de dados

1. Inicie o MySQL pelo painel do XAMPP.
2. Abra o phpMyAdmin em [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
3. Importe o arquivo `database/toymania.sql`.

Esse arquivo cria o banco `toymania_db`, as tabelas `funcionarios`, `categorias`, `produtos` e `produto_imagens`, as chaves estrangeiras e sete categorias iniciais (Bonecas, Carrinhos, Jogos educativos e outras).

Ele não cria funcionário nem senha. O primeiro acesso é feito pela própria aplicação, para não deixar uma credencial padrão no sistema.

Se precisar reinstalar do zero, apague o banco `toymania_db` no phpMyAdmin e importe o arquivo outra vez.

## Configurar a conexão

Abra `config/database.php` e confira estes valores:

```php
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'toymania_db');
define('DB_USER', 'root');
define('DB_PASS', '');
```

No XAMPP, o usuário costuma ser `root` e a senha fica vazia. Se o MySQL recusar o acesso, coloque em `DB_PASS` a senha que você definiu.

## Executar no XAMPP

1. Copie esta pasta para o diretório `htdocs` do XAMPP.
   - Windows: `C:\xampp\htdocs\lojabrinquedos`
   - macOS: `/Applications/XAMPP/xamppfiles/htdocs/lojabrinquedos`
2. Inicie **Apache** e **MySQL** no painel do XAMPP.
3. Importe `database/toymania.sql`, como descrito acima.
4. Confira `config/database.php`.
5. Garanta que a pasta `uploads/produtos` exista e possa receber arquivos. No XAMPP isso já funciona na maioria dos casos. Se o envio de fotos falhar com mensagem de permissão, dê permissão de escrita a essa pasta.

Para enviar várias fotos de uma vez, o PHP precisa aceitar o tamanho total do formulário. Se necessário, ajuste no `php.ini` do XAMPP:

```ini
upload_max_filesize = 8M
post_max_size = 24M
```

Reinicie o Apache depois de alterar o `php.ini`.

### Alternativa sem XAMPP

Na pasta do projeto, com o MySQL já importado:

```bash
php -S localhost:8000 router.php
```

Abra [http://localhost:8000](http://localhost:8000). O arquivo `router.php` só é necessário nesse modo. No Apache, as regras ficam nos arquivos `.htaccess`.

## Acessar o sistema

Com a pasta em `htdocs/lojabrinquedos`, o endereço é:

[http://localhost/lojabrinquedos/](http://localhost/lojabrinquedos/)

Se o Apache apontar direto para esta pasta, use [http://localhost/](http://localhost/).

Quem não estiver autenticado é enviado para a tela de login. As páginas internas não abrem sem uma sessão válida.

## Primeiro cadastro de funcionário

1. Acesse o endereço do sistema.
2. Como ainda não existe funcionário, a aplicação abre `setup.php`.
3. Informe nome, e-mail e uma senha com pelo menos 6 caracteres.
4. O cargo desse primeiro acesso fica como **Administrador**.
5. Depois do cadastro, entre pela tela de login com o e-mail e a senha que você escolheu.

A tela de configuração inicial deixa de aceitar novos cadastros assim que o primeiro funcionário existe. Não há usuário `admin` nem senha pronta no banco.

Funcionários inativos não conseguem entrar. Ninguém pode desativar ou excluir a própria conta. Se um funcionário que cadastrou produtos for excluído, esses produtos passam para a pessoa que fez a exclusão.

## Organização

```text
assets/          CSS, JavaScript e a logo
config/          conexão e configurações gerais
includes/        sessão, validação, layout e uploads
uploads/produtos fotos enviadas
funcionarios/    cadastro da equipe
produtos/        catálogo e galeria
categorias/      categorias dos brinquedos
database/        script de criação do banco
login.php        entrada no sistema
setup.php        criação do primeiro administrador
index.php        dashboard
```

As senhas são gravadas com `password_hash()` e conferidas com `password_verify()`. As consultas usam PDO com prepared statements. Os formulários enviam um token de proteção contra CSRF, e o texto exibido nas páginas passa por escape para evitar XSS.

As fotos aceitas são JPG, JPEG, PNG e WEBP, com até 2 MB cada e no máximo 10 por produto. O arquivo é relido com a biblioteca GD antes de ser salvo, e a pasta de uploads não executa scripts.
