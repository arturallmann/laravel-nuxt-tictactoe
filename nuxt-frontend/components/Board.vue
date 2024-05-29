<template>
  <div class="board-container">
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

        const winner = this.checkForWin();

        if (winner) {
          this.gameEnd(winner);
        } else if (this.checkForDraw()) {
          this.gameEnd();
        } else {
          this.currentPlayer = 'O';
          this.computerPlay();
        }
      }
    },
    startSide() {
      let startingSide = Math.round(Math.random(0, 1)) === 1 ? 'X' : 'O';
      this.currentPlayer = startingSide;
      console.log(startingSide + ' is starting the game');
      if (startingSide === 'O') {
        this.computerPlay();
      }
    },
    gameEnd(winner = null) {
      this.boardDisabled = true;
      if (!winner) {
        console.log('draw!');
        this.postGame('player', 'computer', 'draw', null);
      } else if (winner) {
        console.log(winner + ' wins!');
        this.postGame(
          'player',
          'computer',
          'win',
          winner === 'X' ? 'player' : 'computer'
        );
      }
    },
    checkForWin() {
      //check if rows have a win
      for (let i = 0; i <= 6; i += 3) {
        let s1 = this.squares[i];
        let s2 = this.squares[i + 1];
        let s3 = this.squares[i + 2];
        if (s1 == s2 && s2 == s3 && s1 != '') {
          return s1;
        }
      }
      //check if columns have a win
      for (let i = 0; i <= 3; i++) {
        let s1 = this.squares[i];
        let s2 = this.squares[i + 3];
        let s3 = this.squares[i + 6];
        if (s1 == s2 && s2 == s3 && s1 != '') {
          return s1;
        }
      }
      //check if diagonals have a win
      let s1 = this.squares[0];
      let s2 = this.squares[4];
      let s3 = this.squares[8];
      if (s1 == s2 && s2 == s3 && s1 != '') {
        return s1;
      }
      let s4 = this.squares[2];
      let s5 = this.squares[6];
      if (s2 == s4 && s4 == s5 && s2 != '') {
        return s2;
      }
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
          const winner = this.checkForWin();
          if (winner) {
            this.gameEnd(winner);
          } else if (this.checkForDraw()) {
            this.gameEnd();
          } else {
            this.currentPlayer = 'X';
          }
        }
      }, 500);
    },
    postGame(player_x, player_o, game_state, winner) {
      //currently disabled so database doesn't fill up
      const { data } = $fetch('http://localhost:8000/api/games', {
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
.board {
  display: grid;
  grid-template-columns: repeat(3, 200px);
  gap: 5px;
  width: 100%;
  height: 100%;
  max-width: 70%; /* Adjust as necessary */
  max-height: 70%; /* Adjust as necessary */
}
.restart {
  background-color: #bfffbc;
  border-radius: 5px;
}
</style>
