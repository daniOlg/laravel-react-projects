## Installation

To install the project, follow these steps:

1. Copy the `.env.example` file to `.env`:
    ```bash
    cp .env.example .env
    ```

2. Install PHP dependencies:
    ```bash
    composer install
    ```

3. Install JavaScript dependencies:
    ```bash
    npm install
    ```

4. Generate a new application key:
    ```bash
    php artisan key:generate
    ```

5. Set up your database connection in the `.env` file.

6. Run the database migrations:
    ```bash
    php artisan migrate
    ```

## Using PROJECTS - API + WEB

To use PROJECTS - API + WEB, follow these steps:

1. Start the local development server:
    ```bash
    php artisan serve
    ```

You can now access the server at [http://localhost:8000](http://localhost:8000)


## API Endpoints

### Autenticación
| Endpoint            | Método | Descripción                                        |
|---------------------|--------|----------------------------------------------------|
| /auth/register      | POST   | Registra un nuevo usuario.                         |
| /auth/login         | POST   | Inicia sesión y genera un token de autenticación.  |
| /auth/logout        | POST   | Cierra sesión y revoca el token actual.            |
| /auth/refresh       | POST   | Refresca el token de autenticación.                |
| /auth/me            | POST   | Obtiene la información del usuario autenticado.    |

### Proyectos
| Endpoint            | Método | Descripción                                        |
|---------------------|--------|----------------------------------------------------|
| /projects           | GET    | Lista todos los proyectos.                         |
| /projects           | POST   | Crea un nuevo proyecto.                            |
| /projects/{project} | GET    | Muestra los detalles de un proyecto específico.    |
| /projects/{project} | PUT    | Actualiza la información de un proyecto existente. |
| /projects/{project} | DELETE | Elimina un proyecto específico.                    |


