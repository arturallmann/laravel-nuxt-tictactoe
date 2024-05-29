<template>
  <div class="game-container">
    <div class="board-container">
      <Board />
    </div>
    <div class="history-container">
      <History />
    </div>
  </div>
</template>
<script></script>
<style scoped>
.game-container {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  padding: 20px;
  max-width: 100%;
  flex-wrap: wrap;
}

.board-container {
  flex: 1;
  max-width: 70%;
  justify-content: center;
}

.history-container {
  min-width: 30%;
  margin-left: 20px;
  right: 0;
}
</style>
