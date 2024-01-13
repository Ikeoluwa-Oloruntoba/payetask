setup:
	@make build
	@make up 
	@make composer-update
	@make test

test: 
	@make articles_help
	@make fetch_articles
	@make fetch_articles_limit
	@make fetch_articles_comments
	@make fetch_articles_both


build:
	./vendor/bin/sail build --no-cache

stop:
	./vendor/bin/sail down

up:
	./vendor/bin/sail up -d

composer-update:
	./vendor/bin/sail composer update

fetch_articles:
	./vendor/bin/sail artisan fetch_articles

fetch_articles_limit:
	./vendor/bin/sail artisan fetch_articles --limit=10

fetch_articles_comments:
	./vendor/bin/sail artisan fetch_articles --has_comments_only

fetch_articles_both:
	./vendor/bin/sail artisan fetch_articles --limit=10 --has_comments_only

articles_help:
	./vendor/bin/sail artisan --help fetch_articles



