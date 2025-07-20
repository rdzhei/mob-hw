coldstart:
	docker-compose -f ./docker/docker-compose.yml -p mob-ws up -d
	#docker exec -w /var/www/html mob-ws_php-app_1 composer install
	#docker exec -w /var/www/html mob-ws_php-app_1 chown www-data:www-data vendor

start:
	docker-compose -f ./docker/docker-compose.yml start

up:
	docker-compose -f ./docker/docker-compose.yml -p mob-ws up -d

down:
	docker-compose -f ./docker/docker-compose.yml -p mob-ws down