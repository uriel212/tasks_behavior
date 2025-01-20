# Welcome to Tasks Manager App
This is a simple tasks manager api working with jwt authentication.

## Features
- User can create an account
- User can login
- User can create a task
- User can view all his tasks
- User can view a single task (Only if he created the task)
- User can update a task (Only if he created the task)
- User can delete a task (Only if he created the task)

## How to run the app
- Clone the repository
`git clone https://github.com/uriel212/tasks_behavior.git`

- Run the migrations with
`php artisan migrate`

- Run the secret key generator
`php artisan jwt:secret`
This key will be used to generate the jwt token and you need to add it to .env.testing as JWT_SECRET if you want to run the tests with `php artisan test`

- Run the app
`php artisan serve`

- Run the tests
`php artisan test`

## Endpoints
- POST /api/register
- POST /api/login
- POST /api/tasks
- GET /api/tasks
- GET /api/tasks/{id}
- PUT /api/tasks/{id}
- DELETE /api/tasks/{id}


Made with love by uriel212 💙