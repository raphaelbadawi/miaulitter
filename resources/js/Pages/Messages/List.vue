<template>
  <div>
    <div v-for="message in messages" :key="message.id">
      <div class="relative font-bold mt-5 left-offset">Message de {{ message.author.name }}</div>
      <p class="bg-white p-5 rounded shadow mt-3 w-2/3 mx-auto">{{ message.content }}</p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    messages: Array,
  },
};
</script>

<style scoped>
  .left-offset {
    left: 16.66%;
  }
</style>