<template>
  <div class="games-history">
    <h1>History</h1>
    <ul v-if="games && games.length">
      <li v-for="game in games" :key="game.id">
        <div class="history-item">
          <p>Result: {{ game.game_state }}</p>
          <p v-if="game.winner">Winner: {{ game.winner }}</p>
          <p v-else></p>
          <p>Created At: {{ new Date(game.created_at).toLocaleString() }}</p>
        </div>
      </li>
    </ul>
    <p v-else-if="isFetching">Loading games...</p>
    <p v-else-if="error">{{ error.message }}</p>
  </div>
</template>
<script setup>
const {
  data,
  pending: isFetching,
  error,
} = useFetch('${$config.apiUrl}/api/games');
const games = computed(() => data.value?.games || []);
</script>
<style scoped>
.games-history {
  margin: 20px;
  max-height: 80vh;
  overflow-y: scroll;
}
.history-item {
  border: 1px solid black;
  border-radius: 10px;
  background-color: #a8aec1;
}
.history-item p {
  padding-left: 5px;
  color: black;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  padding: 10px;
  margin-bottom: 10px;
}
</style>
