## Laravel Restful API
A restful API for a Task Management system built with the Laravel framework. It provides seamless communication and data exchange between client applications and the server, following RESTful principles.

You can find an installation guide below.

# Live Demo:

https://github.com/AHMED-GAMAL-AG/task-management-api/assets/76778937/f453afa6-d5aa-428d-a77c-ec107bac556c

# Screenshots: 

![image](https://github.com/AHMED-GAMAL-AG/task-management-api/assets/76778937/95d77bdd-e761-4936-b92f-eac5259bf0bb)

You can test the API through the Postman desktop application:

![image](https://github.com/AHMED-GAMAL-AG/LARAVEL_RESTFUL_API/assets/76778937/2575f313-fc58-4772-b1d2-0f6f177a0266)

Endpoints:
● Create a new task
● Update an existing task
● Delete a task
● Retrieve a single task by ID
● Retrieve a list of all tasks
● Retrieve tasks by status (e.g., "in progress," "completed")
● Retrieve tasks that are due within a specified date range

## Features
- validation to ensure that required fields are provided and that due dates are in the future.
- unit tests for the API using Laravel's testing framework
-  error handling and responses for any invalid requests.
- pagination for the data sent in the response
- sort tasks by due date or status.
- API versioning to future-proof the API.

## installation

<ul>
<li><code>git clone https://github.com/AHMED-GAMAL-AG/task-management-api.git</code></li>
<li><code>Create a .env file and configure the database.</code></li>
<li><code>composer install</code></li>
<li><code>npm install</code></li>
<li><code>php artisan key:generate</code></li>
<li><code>php artisan migrate --seed</code></li>
<li><code>php artisan storage:link</code></li>
</ul>
