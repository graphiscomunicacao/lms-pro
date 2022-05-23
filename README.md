<p align="center"><a href="https://graphiscomunicacao.com.br" target="_blank"><img src="https://user-images.githubusercontent.com/33905714/138146965-4f01c48f-094a-41f9-bb19-150d5dd65650.png" width="400"></a></p>


# LMS PRO - Graphis

Esse é um projeto em desenvolvimento. Sempre consulte o readme para alterações no processo de instalação local.

## Requisitos
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/laravel/laravel) 

## Instalação

Executar em sequencia após a clonagem do projeto.

```bash
Sequencia de comandos

# criar arquivo de ambiente local e configurar .env para se conectar ao banco de dados
cp .env.example .env

# instalação de dependencias do php via composer (necessário composer instalado)
composer install

# Geração da chave de criptografia do Laravel
php artisan key:generate

# Criação do banco e semente de dados 
php artisan migrate --seed

# Instalação das dependencias de JavaScript (necessário Node instalado) e compilação de assets
npm install
npm run dev ou npm run watch
```
