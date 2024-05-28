<template>
  <button class="square" @click="handleClick" :disabled='disabled'">{{ value }}</button>
</template>

<script>
export default {
  name: 'Square',
  props: {
    value: String,
    index: Number,
    disabled: Boolean
  },
  methods: {
    handleClick() {
      //check if the square is empty
      if (this.value === '') {
        this.$emit('square-clicked', this.index);
      }
    },
  },
};
</script>

<style scoped>
.square {
  width: 100px;
  height: 100px;
  background-color: #fff;
  border: 1px solid #000;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  cursor: pointer;
}

.square:hover {
  background-color: #f0f0f0;
}
</style>
