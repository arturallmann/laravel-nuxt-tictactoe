# Tic Tac Toe Game API

This API provides endpoints for managing tic tac toe games.

## Endpoints

- **POST /api/games**
  - Create a new tic tac toe game.
  - Request Body:
    - player_x (string, required): Name of player X.
    - player_o (string, required): Name of player O.
    - game_state (string, required): Current state of the game (e.g., "win", "draw", "ongoing").
    - winner (string, optional): Name of the winning player (if applicable).
  - Response: 201 Created

- **GET /api/games**
  - Retrieve a list of all tic tac toe games.
  - Response: 200 OK
  - Response Body:
    ```json
    {
      "games": [
        {
          "id": 1,
          "player_x": "John",
          "player_o": "Jane",
          "game_state": "win",
          "winner": "John",
          "created_at": "2024-06-01T12:00:00.000Z",
          "updated_at": "2024-06-01T12:05:00.000Z"
        },
        // More game objects...
      ]
    }
    ```

- **PUT /api/games/{id}**
  - Update the state of a tic tac toe game.
  - Request Parameters:
    - id (integer, required): ID of the game to update.
  - Request Body:
    - game_state (string, required): Updated state of the game.
    - winner (string, optional): Updated winner of the game (if applicable).
  - Response: 201 Created

- **DELETE /api/games/{id}**
  - Delete a tic tac toe game.
  - Request Parameters:
    - id (integer, required): ID of the game to delete.
  - Response: 201 Created

## Usage

1. **Create a Game**: Send a POST request to `/api/games` with the required parameters in the request body to create a new tic tac toe game.

2. **Retrieve Games**: Send a GET request to `/api/games` to retrieve a list of all tic tac toe games.

3. **Update a Game**: Send a PUT request to `/api/games/{id}` with the ID of the game to update and the updated game state in the request body.

4. **Delete a Game**: Send a DELETE request to `/api/games/{id}` with the ID of the game to delete.

## Installation

If Docker isn't working properly, some steps need to be done manually.

1. **Clone Repository:**
   ```bash
   git clone https://github.com/arturallmann/laravel-nuxt-tictactoe
   ```

2. **Rename Environment File:**
   Create ".env" from the ".env.example" file in the /laravel-server folder

   
4. **Install Dependencies and Migrate Database:**
   ```bash
   cd laravel-server/
   composer install
   php artisan migrate
   php artisan serve
   ```
   if it asks to create a new database, then select 'yes'

5. **Setup Nuxt Frontend:**
   ```bash
   cd ../nuxt-frontend/
   npm install
   npm run generate
   npm run build
   npm run start
   ```

***currently I didn't get it working properly, I couldn't figure it out due to time constraints.***

6. **Run Docker Compose:**
   ```bash
   docker-compose up --build
   ```

7. **Access the Application:**
   Open your web browser and go to [http://localhost:3000](http://localhost:3000) to play!


