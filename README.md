# Chess Game Microservices


This project implements a **chess game** using **PHP**, designed with **SOLID principles** and a **microservices architecture**. It is structured to be scalable, maintainable, and modular.

All classes are contained within the same file for simplicity.

## Project Structure

```
chess-microservices/
│── src/
│   ├── Services/
│   │   ├── PieceService/
│   │   │   ├── MovableInterface.php
│   │   │   ├── ChessPiece.php
│   │   │   ├── Pawn.php
│   │   │   ├── Rook.php
│   │   │   ├── Knight.php
│   │   │   ├── Bishop.php
│   │   │   ├── Queen.php
│   │   │   ├── King.php
│   │   ├── BoardService/
│   │   │   ├── Board.php
│   │   ├── MoveService/
│   │   │   ├── MoveService.php
│   │   ├── GameService/
│   │   │   ├── GameService.php
│── api/
│   ├── index.php  # API Gateway (Handles HTTP Requests)
│── tests/
│   ├── BoardTest.php
│   ├── MoveServiceTest.php
│   ├── GameServiceTest.php
│── config/
│   ├── config.php  # Configuration settings (optional)
│── vendor/  # Composer dependencies (if using Composer)
│── composer.json  # Composer dependencies configuration
│── README.md  # Project Documentation
```

## Architectural Decisions

The project follows **SOLID principles** to ensure a well-structured and maintainable system:

- **Single Responsibility Principle (SRP):** Each class has a single responsibility, such as handling moves, validating rules, or managing the board state.
- **Open/Closed Principle (OCP):** The system allows extending functionalities without modifying existing code (e.g., adding new piece types).
- **Liskov Substitution Principle (LSP):** All chess pieces inherit from a common base class and can be used interchangeably.
- **Interface Segregation Principle (ISP):** Separate interfaces for different chess behaviors (e.g., `MovableInterface`).
- **Dependency Inversion Principle (DIP):** High-level modules depend on abstractions rather than concrete implementations.

### Microservices Architecture

The application is broken down into multiple microservices for better scalability:

- **Game Service:** Manages the chess game state.
- **Move Service:** Validates and executes moves.
- **Board Service:** Stores the chessboard state.
- **Piece Service:** Defines chess pieces and movement rules.
- **API Gateway:** Central point for communication between services.

## How to Use the Code

### Prerequisites

- Install **PHP 8+**

### Installation

1. **Clone the Repository:**
   ```sh
   git clone https://github.com/vfpereira/chess-microservices.git
   cd chess-microservices
   ```

### Running the Game

- The `api/index.php` file acts as the **API Gateway**.
- To test the game, you can call the game logic from the command line or set up an HTTP request.

# Example HTTP Request

## Set up PHP Server

To run the server, use the following command:

```sh
php -S localhost:8000
```

##  Example Client Request
You can test the API using the following curl command:

```sh
curl -X POST http://localhost/api/index.php -d '{"startX":0, "startY":1, "endX":0, "endY":2}'
```

# API Parameters

The following parameters are required for making a valid request:

- **`startX`** (int): The starting X coordinate of the piece.
- **`startY`** (int): The starting Y coordinate of the piece.
- **`endX`** (int): The ending X coordinate of the piece.
- **`endY`** (int): The ending Y coordinate of the piece.


## Example Response:

{
    "message": "Move successful"
}



## Future Improvements
- Implement additional pieces
- Add a frontend interface (React, Vue, or Angular).
- Implement database persistence.
- Add more game rules (check, checkmate, castling, en passant).
- Implement PHPUnit tests
