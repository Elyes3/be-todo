# todoflutter

Todolist app with Symfony

## Installation
You need to have `PHP`, `Composer`, `Symfony` and `MongoDB` set up in your environment.
First of all, this project needs to be cloned either by using Git or by downloading the ZIP and extracting it to your environment (Clone URL: https://github.com/Elyes3/be-todo.git)
Right after that, the dependencies of the project should be installed through the command:
```composer install```.
After that you need to run the project:
```symfony serve```.
## Explanation

- This app makes use of fos_rest in order to expose the APIs through the REST architectural style.
- The environment variables are pushed within this GitHub Repo (not a best practice) in order to make the setup of the project simpler.
- You can either run the project locally after setting up `mongodb` and `symfony` using the code. Or you can make use of the `docker-compose.yml` file that contains the configuration for creating a container for the backend and the database (Note that both of these containers were created in the same network in order to make both of them communicate).
- CORS was setup in order to give access to the web browser to access the server.
- 5 REST API endpoints are provided within this app:
```GET http://<ip>/api/todos?millis={millis}```: Get request that returns all the todos for the millis param passed in. The millis param represents a date converted in milliseconds.
```POST http://<ip>/api/todos```: Post request that allows the creation of a todo. This request requires a JSON object in its body that contains a `description` field , a `completed` field and the `millis` field.
```PATCH http://<ip>/api/todos/{id}/description```: Patch request that makes a partial update on the `description` field of a specific todo.
```PATCH http://<ip>/api/todos/{id}/completed```: Patch request that makes a partial update on the `completed` field of a specific todo.
```DELETE http://<ip>/api/todos/{id}```: Delete request that deletes a specific todo through its id.

## Setup Docker Containers 
- For a windows and Mac Environment, Docker Desktop must be installed:
- On your terminal, after changing your directory on the root of this project, after that run:
``` docker compose -f "docker-compose.yml" up -d --build ``` in order to generate the containers.
Then you have to create the database inside ```MongoDB``` using the MongoDB Shell.
For that you need to run this command after the creation of the containers.
```docker exec -it mongo mongosh```
Then you need to create the database using this command:
```use todo-app```
After that you need to create the collection that will contain all the todos
```db.createCollection("Todo")```
The Mongo Shell part could have been automated through the creation of a `Dockerfile` but it was done for learning purposes in order to get more familiar with `MongoDB Shell`.

PS: In case you're not looking to use `Docker`. Please modify the `MONGODB_URL` in the `.env` file to reference either `localhost` as a replacement of the reference to the container name in the URL(`mongo`).
