cp ./docker/Dockerfile.stage ./Dockerfile

heroku container:push wisermedapi
heroku container:release wisermedapi

cp ./docker/Dockerfile.development ./Dockerfile