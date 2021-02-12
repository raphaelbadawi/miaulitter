<template>
  <div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <form @submit.prevent="tweetStore">
        <textarea
          @keydown.enter="tweetStore"
          v-model="content"
          placeholder="La litière est-elle pleine ?"
          class="rounded-lg border border-gray-200 w-full p-2 font-semibold resize-none focus:outline-none"
        ></textarea>
        <span class="my-5 text-red-500" v-if="$page.props.errors.content">
          {{ $page.props.errors.content }}
        </span>
        <div class="flex items-center space-x-4 justify-end mt-3">
          <p
            class="text-sm text-gray-400 font-thin"
            :class="{ 'text-red-500': remainingChars < 0 }"
          >
            {{ remainingChars }} croquelettres restantes
          </p>
          <button-vue
            class="bg-blue-500 hover:bg-blue-800 rounded-full font-extrabold"
            :disabled="!canSubmit"
            >Miaulisser</button-vue
          >
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import ButtonVue from "@/Jetstream/Button";

export default {
  components: {
    ButtonVue,
  },

  data() {
    return {
      content: "",
      limit: 280,
    };
  },

  computed: {
    remainingChars() {
      return this.limit - this.content.length;
    },
    canSubmit() {
      return this.content.length && this.remainingChars >= 0;
    },
  },

  methods: {
    tweetStore() {
      this.$inertia.post(
        "meows",
        { content: this.content },
        { preserveState: false }
      );
    },
  },
};
</script>

<style scoped>
button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>