<p align="center">
<img src="https://user-images.githubusercontent.com/42893446/138397218-3844868e-c3b6-4566-9652-b6b46d13fed8.png" width="250px" style="border-radius: 8px">
</p>


<h2 align="center">Welcome to wp-docker π</h2>

> Wordpress Working template

## DB

DB μ»¨νμ΄λλ₯Ό λ°λ‘ κ΄λ¦¬νλ ννλ¦Ώμλλ€.

DB μ»¨νμ΄λμ λ€νΈμν¬ μ΄λ¦μ `db_work` μ»¨νμ΄λ μλΉμ€ λ€μμ `workdb`


## 1. Folder set up

```sh
make setup
```

## 2. WordPress Theme

use roots/sage

```sh
docker run --rm --interactive --tty \
--volume $PWD:/app \
--volume ${COMPOSER_HOME:-$HOME/.composer}:/tmp \
composer create-project roots/sage src dev-master
```

## 3. `docker-compose up -d`

`.env` **μ°Έκ³ **

```
WORDPRESS_DB_USER=
WORDPRESS_DB_PASSWORD=
WORDPRESS_DB_NAME=
PROJECT_NAME=
PROJECT_PORT=
```

## Author

π€ **Hansanghyeon**

* Website: [hyeon.pro](https://hyeon.pro)
* Github: [@Hansanghyeon](https://github.com/Hansanghyeon)
