# **Monkey ApiFake**

###Requisitos: 
- docker
- make

###Como executar: 

- Com Make: _Acessa a pasta raiz e roda o comando `make deploy_run`_
- Sem Make: 
  - `docker-compose build api-fake`
  - `docker-compose up -d api-fake`
  - `docker exec api-fake composer install`
  - `docker exec api-fake chmod 777 /app`
    
Apos isso a aplicação vai estar executando em localhost:82