<template>
  <div class="board">
    <Square
      v-for="(square, index) in squares"
      :key="index"
      :value="square"
      :index="index"
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
        if (this.checkForWin()) {
          //TODO: disable all other inputs
        }
        this.currentPlayer = this.currentPlayer === 'X' ? 'O' : 'X';
      }
    },
    checkForWin() {
      //check if rows have a win
      for (let i = 0; i <= 8; i += 3) {
        let s1 = this.squares[i];
        let s2 = this.squares[i + 1];
        let s3 = this.squares[i + 2];
        if (s1 == s2 && s2 == s3 && s1 != '') {
          alert(s1 + ' Wins!');
        }
      }
      //check if columns have a win
      for (let i = 0; i <= 3; i++) {
        let s1 = this.squares[i];
        let s2 = this.squares[i + 3];
        let s3 = this.squares[i + 6];
        if (s1 == s2 && s2 == s3 && s1 != '') {
          alert(s1 + ' Wins!');
        }
      }
      //check if diagonals have a win
      let s1 = this.squares[0];
      let s2 = this.squares[4];
      let s3 = this.squares[8];
      if (s1 == s2 && s2 == s3 && s1 != '') {
        alert(s1 + ' Wins!');
      }
      let s4 = this.squares[2];
      let s5 = this.squares[6];
      if (s2 == s4 && s4 == s5 && s2 != '') {
        alert(s2 + ' Wins!');
      }
    },
    restartGame() {
      this.squares = Array(9).fill('');
      this.currentPlayer = startSide();
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
