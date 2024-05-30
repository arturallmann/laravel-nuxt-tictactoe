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
          this.computerPlay();
        }
      }
    },
    startSide() {
      let startingSide = Math.round(Math.random(0, 1)) === 1 ? 'X' : 'O';
      this.currentPlayer = startingSide;
      this.gameState = startingSide + "'s Turn";

      console.log(startingSide + ' is starting the game');
      if (startingSide === 'O') {
        this.computerPlay();
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
        console.log(winner + ' wins!');
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
    computerPlay() {
      setTimeout(() => {
        let moveMade = false;
        for (let i = 0; i <= 8; i++) {
          if (this.squares[i] === '') {
            this.squares[i] = 'O';
            this.currentPlayer = 'X';
            moveMade = true;
            break;
          }
        }
        if (moveMade) {
          const winner = this.checkForWin(this.squares);
          if (winner) {
            this.gameEnd(winner);
          } else if (this.checkForDraw()) {
            this.gameEnd();
          } else {
            this.currentPlayer = 'X';
            this.gameState = "X's Turn";
          }
        }
      }, 500);
    },
    postGame(player_x, player_o, game_state, winner) {
      //currently disabled so database doesn't fill up
      const { data } = useFetch(`${config.public.apiBase}/games`, {
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
