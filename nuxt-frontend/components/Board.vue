<template>
  <div class="board-container">
    <div class="turn-indicator">
      <p>{{ gameState }}</p>
    </div>
    <div class="board">
      <Square
        v-for="(square, index) in squares"
        :key="index"
        :value="square"
        :index="index"
        :disabled="boardDisabled"
        @square-clicked="handleSquareClick"
      />
    </div>
    <button @click="restartGame" class="restart">Restart game</button>
  </div>
</template>

<script>
import Square from './Square.vue';

export default {
  name: 'Board',
  components: {
    Square,
  },
  data() {
    return {
      squares: Array(9).fill(''),
      currentPlayer: '',
      boardDisabled: false,
      gameState: '',
    };
  },
  created() {
    this.startSide();
  },
  methods: {
    handleSquareClick(index) {
      console.log(`Square click handled: ${index}`);
      if (
        this.squares[index] === '' &&
        !this.boardDisabled &&
        this.currentPlayer === 'X'
      ) {
        this.squares[index] = this.currentPlayer;

        const winner = this.checkForWin(this.squares);

        if (winner) {
          this.gameEnd(winner);
        } else if (this.checkForDraw()) {
          this.gameEnd();
        } else if (!winner) {
          this.currentPlayer = 'O';
          this.gameState = "O's Turn";
          this.makeComputerMove();
        }
      }
    },
    startSide() {
      let startingSide = Math.round(Math.random(0, 1)) === 1 ? 'X' : 'O';
      this.currentPlayer = startingSide;
      this.gameState = startingSide + "'s Turn";

      if (startingSide === 'O') {
        this.makeComputerMove();
      }
    },
    gameEnd(winner = null) {
      this.boardDisabled = true;
      if (!winner) {
        this.gameState = 'Draw!';
        console.log('draw!');
        this.postGame('player', 'computer', 'draw', null);
      } else if (winner) {
        this.gameState = winner + ' Wins!';
        this.postGame(
          'player',
          'computer',
          'win',
          winner === 'X' ? 'player' : 'computer'
        );
      }
    },
    //check if rows have a win
    checkForWin(squares) {
      const winningCombinations = [
        [0, 1, 2], // Rows
        [3, 4, 5],
        [6, 7, 8],
        [0, 3, 6], // Columns
        [1, 4, 7],
        [2, 5, 8],
        [0, 4, 8], // Diagonals
        [2, 4, 6],
      ];

      for (const combination of winningCombinations) {
        const [a, b, c] = combination;
        if (
          squares[a] &&
          squares[a] === squares[b] &&
          squares[a] === squares[c]
        ) {
          return squares[a]; // Return the winning player ('X' or 'O')
        }
      }
      return null; // No winner
    },
    checkForDraw() {
      // Check if all squares are filled
      return this.squares.every((square) => square !== '');
    },
    restartGame() {
      this.squares = Array(9).fill('');
      this.startSide();
      this.boardDisabled = false;
    },
    makeComputerMove() {
      this.boardDisabled = true;
      setTimeout(() => {
        // Check if the computer can win in the next move
        let winningMove = this.findWinningMove('O');
        if (winningMove !== null) {
          this.squares[winningMove] = 'O';
        } else {
          // Check if the player can win in the next move and block them
          let blockingMove = this.findWinningMove('X');
          if (blockingMove !== null) {
            this.squares[blockingMove] = 'O';
          } else {
            // Choose the best available spot based on a simple scoring system
            let bestMove = this.findBestMove();
            this.squares[bestMove] = 'O';
          }
        }
        this.boardDisabled = false;
        // Check for win or draw after computer's move
        const winner = this.checkForWin(this.squares);
        if (winner) {
          this.gameEnd(winner);
        } else if (this.checkForDraw()) {
          this.gameEnd();
        } else if (!winner) {
          this.currentPlayer = 'X';
          this.gameState = "X's Turn";
        }
      }, 500);
    },

    findWinningMove(letter) {
      for (let i = 0; i < this.squares.length; i++) {
        if (this.squares[i] === '') {
          // Try making the move and check if it results in a win
          this.squares[i] = letter;
          if (this.checkForWin(this.squares) === letter) {
            // Undo the move and return the winning move
            this.squares[i] = '';
            return i;
          }
          // Undo the move
          this.squares[i] = '';
        }
      }
      return null;
    },

    findBestMove() {
      // A simple scoring system: prioritize center, corners, and then edges
      const center = 4;
      const corners = [0, 2, 6, 8];
      const edges = [1, 3, 5, 7];

      // Prioritize center
      if (this.squares[center] === '') {
        return center;
      }

      // Prioritize corners
      for (let corner of corners) {
        if (this.squares[corner] === '') {
          return corner;
        }
      }

      // Choose any available edge
      for (let edge of edges) {
        if (this.squares[edge] === '') {
          return edge;
        }
      }
      // No available spot (should not reach this point in a valid game)
      return -1;
    },
    postGame(player_x, player_o, game_state, winner) {
      //currently disabled so database doesn't fill up
      const { data } = useFetch(`http://localhost/api/games`, {
        method: 'POST',
        body: {
          player_x: player_x,
          player_o: player_o,
          game_state: game_state,
          winner: winner,
        },
      });
    },
  },
};
</script>

<style scoped>
.board-container {
  width: 39rem;
  padding: 20px;
}
.turn-indicator {
  margin-left: 10rem;
  margin-right: 10rem;
  width: 50%;
  height: 10%;
  border: 1px solid black;
  border-radius: 5px;
  color: black;
  text-align: center;
}

.board {
  padding: 5px;
  display: grid;
  grid-template-columns: repeat(3, 12.5rem);
  gap: 0.5rem;
  width: 100%;
  height: 100%;
  max-width: 80%; /* Adjust as necessary */
  max-height: 80%; /* Adjust as necessary */
}
.restart {
  background-color: #bfffbc;
  border-radius: 5px;
}
</style>
