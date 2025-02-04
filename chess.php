<?php
// 1. Piece Service: Defines Chess Pieces and Movement Rules
interface MovableInterface {
    public function canMove(int $startX, int $startY, int $endX, int $endY): bool;
}

abstract class ChessPiece implements MovableInterface {
    protected string $color;

    public function __construct(string $color) {
        $this->color = $color;
    }

    public function getColor(): string {
        return $this->color;
    }
}

class Pawn extends ChessPiece {
    public function canMove(int $startX, int $startY, int $endX, int $endY): bool {
        return ($this->color === 'white') ? $endY === $startY + 1 : $endY === $startY - 1;
    }
}

// Other pieces (Rook, Knight, Bishop, Queen, King) follow similar implementations

// 2. Board Service: Stores the Chessboard State
class Board {
    private array $grid;

    public function __construct() {
        $this->initializeBoard();
    }

    private function initializeBoard(): void {
        $this->grid = [
            //[new Rook('black'), new Knight('black'), new Bishop('black'), new Queen('black'), new King('black'), new Bishop('black'), new Knight('black'), new Rook('black')],
            array_fill(0, 8, null),
            [new Pawn('white'), new Pawn('white'), new Pawn('white'), new Pawn('white'), new Pawn('white'), new Pawn('white'), new Pawn('white'), new Pawn('white')],
            array_fill(0, 8, null),
            array_fill(0, 8, null),
            array_fill(0, 8, null),
            array_fill(0, 8, null),
            [new Pawn('black'), new Pawn('black'), new Pawn('black'), new Pawn('black'), new Pawn('black'), new Pawn('black'), new Pawn('black'), new Pawn('black')],
            array_fill(0, 8, null),
            //[new Rook('white'), new Knight('white'), new Bishop('white'), new Queen('white'), new King('white'), new Bishop('white'), new Knight('white'), new Rook('white')]
        ];
    }

    public function getPiece(int $x, int $y): ?ChessPiece {
        return $this->grid[$y][$x] ?? null;
    }

    public function movePiece(int $startX, int $startY, int $endX, int $endY): bool {
        $piece = $this->getPiece($startX, $startY);
        if ($piece && $piece->canMove($startX, $startY, $endX, $endY)) {
            $this->grid[$endY][$endX] = $piece;
            $this->grid[$startY][$startX] = null;
            return true;
        }
        return false;
    }
}

// 3. Move Service: Validates and Executes Moves
class MoveService {
    private Board $board;

    public function __construct(Board $board) {
        $this->board = $board;
    }

    public function executeMove(int $startX, int $startY, int $endX, int $endY): bool {
        return $this->board->movePiece($startX, $startY, $endX, $endY);
    }
}

// 4. Game Service: Manages Chess Game State
class GameService {
    private Board $board;
    private MoveService $moveService;

    public function __construct() {
        $this->board = new Board();
        $this->moveService = new MoveService($this->board);
    }

    public function playMove(int $startX, int $startY, int $endX, int $endY): string {
        return $this->moveService->executeMove($startX, $startY, $endX, $endY) ? "Move successful" : "Invalid move";
    }
}

// 5. API Gateway: Handles HTTP Requests
class ChessController {
    private GameService $gameService;

    public function __construct(GameService $gameService) {
        $this->gameService = $gameService;
    }

    public function handleRequest(): void {
        $data = json_decode(file_get_contents("php://input"), true);
        $startX = $data['startX'];
        $startY = $data['startY'];
        $endX = $data['endX'];
        $endY = $data['endY'];

        $result = $this->gameService->playMove($startX, $startY, $endX, $endY);
        echo json_encode(['message' => $result]);
    }
}


// Instantiate GameService
$gameService = new GameService();

// Instantiate ChessController
$controller = new ChessController($gameService);

// Handle the request (this would simulate handling a request from CLI)
$controller->handleRequest();
