PatoBeta
=========

Sistema de controle de usuários e caixa para MEI´s e pequenas empresas, com controle de usuários e ACL

Para testar o sistema pode-se utilizar o link: http://pato-adirkuhn.rhcloud.com/
usuario: demo@demo.com
senha: demo

Informações e Instalação
========================

O sistema foi desenvolvido utilizando Symfony2, Bootstrap e MySQL.
Devido a algumas implementações de views o sistema deve utilizar MySQL ou MariaDB.

Como o sistema é feito em symfony a instalação é simples:

1# Puxe o código via GitHub
2# Instale o composer (https://getcomposer.org/)
3# Instale as dependencias do projetos (composer install)
4# Crie o banco de dados (~/php app/console doctrine:database:create)
5# Crie as tabelas no banco de dados (~/php app/console doctrine:schema:create)
6# No mysql crie a VIEW 'cashflow' contida no arquivo sql.sql

Dúvidas para adir[at]nuvem.coffee