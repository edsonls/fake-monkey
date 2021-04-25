deploy_run:
	docker-compose build api-fake
	docker-compose up -d api-fake
	docker exec api-fake composer install
	docker exec api-fake chmod 777 /app