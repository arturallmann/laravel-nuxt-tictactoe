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
        this.currentPlayer = this.currentPlayer === 'X' ? 'O' : 'X';
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
