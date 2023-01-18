#!/bin/bash
echo ""
echo "###################################"
echo "### Graffiti Wall Initial Setup ###"
echo "###################################"
echo ""
echo 'Building containers...'
docker-compose up -d
echo 'Copying environment variables...'
cp src/.env.example src/.env
echo 'Generating application key...'
docker-compose run --rm artisan key:generate
echo 'Setting storage and cache permissions...'
chmod 755 -R src/storage/ src/bootstrap/cache/
echo 'Running database migrations and seeds...'
docker-compose run --rm artisan migrate && docker-compose run --rm artisan db:seed
echo 'Installing npm packages...'
docker-compose run --rm npm install
echo 'Building frontend assets...'
docker-compose run --rm npm run prod
echo ""
echo 'Done'