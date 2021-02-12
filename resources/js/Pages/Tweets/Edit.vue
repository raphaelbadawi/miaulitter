<template>
  <div class="flex flex-col w-2/3">
    <form @submit.prevent="tweetUpdate">
      <textarea
        @keydown.enter="tweetUpdate"
        v-model="tweetContent"
        class="rounded-lg border border-gray-200 w-full p-2 font-semibold resize-none focus:outline-none"
      ></textarea>
      <button
        class="bg-indigo-500 text-white cursor-pointer px-5 py-2 float-right rounded-full mt-2"
        type="submit"
      >
        Graou
      </button>
    </form>
  </div>
</template>

<script>
export default {
  props: {
    tweetId: Number,
    tweetContent: String,
  },

  methods: {
    tweetUpdate() {
      this.$emit('tweetUpdated');
      this.$inertia.patch(
        `meows/${this.tweetId}`,
        { tweetContent: this.tweetContent },
        { preserveState: true }
      );
    },
  },
};
</script>