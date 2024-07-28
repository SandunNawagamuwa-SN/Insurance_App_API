## How to Run

1. Clone the Repository

    git clone <repository-url>

2. Navigate into the Cloned Project Directory:

    cd <project-name>

3. Install Dependencies:

    composer install

4. Open Project in VS Code:

    code .

5. After Open open VS Code and Click Trust Other, Press

    Ctrl + Shift + ` (Open new terminal)

6. Create Environment File using opened terminal:

   cp .env.example .env

7. Create Database and Configure it on .env file:

    # DB_CONNECTION=mysql
    # DB_HOST=
    # DB_PORT=
    # DB_DATABASE=
    # DB_USERNAME=
    # DB_PASSWORD=

8. Generate Encryption Key:

   php artisan key:generate

9. Run Migrations:

    php artisan migrate

10. Start the Development Server:

    php artisan serve


## Design Decisions

1. Follows repository design pattern

2. Use One to Many Relationship between Insurance Policy and User (Insurance Policy Maker)

3. All authenticated users can view and edit insurance policies

4. But the delete of insurance policy can be done only the maker of that policy (Authorization done by using Gate)





