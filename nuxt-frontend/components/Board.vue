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
    };
  },
  methods: {
    handleSquareClick(index) {
      console.log(`Square click handled: ${index}`); // Debugging log
      if (this.squares[index] === '') {
        this.squares[index] = 'X';
      }
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
}
</style>
