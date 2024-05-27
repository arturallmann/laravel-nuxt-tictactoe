<template>
  <div class="board">
    <Square
      v-for="(square, index) in squares"
      :key="index"
      :value="square"
      :index="index"
      :class="{ disabled: currentPlayer !== 'X' }"
      @square-clicked="handleSquareClick"
    />
  </div>
  <button @click="restartGame" class="restart">Restart game</button>
</template>

<script>
import Square from './Square.vue';
import TurnIndicator from './TurnIndicator.vue';
const startSide = () => {
  let startingSide = Math.round(Math.random(0, 1)) === 1 ? 'X' : 'O';
  return startingSide;
};
export default {
  name: 'Board',
  components: {
    Square,
    TurnIndicator,
  },
  data() {
    return {
      squares: Array(9).fill(''),
      currentPlayer: startSide(),
    };
  },
  methods: {
    handleSquareClick(index) {
      console.log(`Square click handled: ${index}`);
      if (this.squares[index] === '') {
        this.squares[index] = this.currentPlayer;

        const winner = this.checkForWin();
        if (winner) {
          this.disableBoard();
          if (winner === 'X') {
            //TODO: disable all other inputs
            this.postGame('player', 'computer', 'win', 'player');
          } else if (winner === 'O') {
            this.postGame('player', 'computer', 'loss', 'computer');
          }
        } else if (this.checkForDraw()) {
          this.postGame('player', 'computer', 'draw', null);
        }

        this.currentPlayer = this.currentPlayer === 'X' ? 'O' : 'X';
      }
    },
    disableBoard() {
      // Disable all squares by setting them to a non-empty value
      this.squares = this.squares.map((square) =>
        square === '' ? '-' : square
      );
    },
    checkForWin() {
      //check if rows have a win
      for (let i = 0; i <= 8; i += 3) {
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
      this.currentPlayer = startSide();
    },
    postGame(player_x, player_o, game_state, winner) {
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
  grid-template-columns: repeat(3, 100px);
  grid-template-rows: repeat(3, 100px);
  gap: 5px;
  background-color: darkgrey;
  justify-content: center;
}
</style>
