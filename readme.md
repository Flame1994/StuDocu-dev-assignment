# StuDocu Interactive Q&A

ʕ•ᴥ•ʔﾉ Welcome! This assignment handles Laravel's interactive console.

## Requirements
There are a few things needed in order to setup this project.
- PHP
- SQLite
- **[Composer](https://getcomposer.org/)**
- **[Laravel](https://laravel.com/docs/8.x/installation)**
- A server to host it on (whichever you prefer)

## Installation
First, clone this repository and navigate to the directory where it has been downloaded. Follow the instructions below:

- Run the Composer installation
```jshelllanguage
$ composer install
```
- Update the `.env` file with all needed information, specifically the database details.
- Migrate the database
```jshelllanguage
$ php artisan migrate
```

## Implementation

### Summary
**Laravel**, which is a MVC (Model View Controller) framework is used in this implementation, alongside a **Repository** design pattern. A base abstract command
class is created which handles the application flow of the other commands. The Commands
interact with the models through the repositories.

### Models
Using the Eloquent ORM, models can be created that map directly to database tables. For our implementation we have the **Question** and **Answer** Models.

### Repositories
A Repository is an abstraction of the data layer and a centralised way of handling our models. 
The idea with this pattern is to have a generic abstract way for the commands to work with the data 
layer without being bothered with if the implementation is towards a local database or towards an online API.

## Testing
You can test the commands as well. You can view them in the `tests/Unit` folder. Navigate to your project folder and run the following command to run the tests:
```jshelllanguage
phpunit tests/Unit
```

## Testing the assignment
To test the assignment, simply run the command
```jshelllanguage
php artisan qanda:interactive
```
You will be prompted for the relevant information and taken through the steps.