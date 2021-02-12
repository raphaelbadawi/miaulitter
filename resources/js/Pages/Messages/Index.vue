<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Du Miail
      </h2></template
    >
    <div class="py-6">
      <transition mode="out-in" name="fade">
        <button
          v-if="!createIsToggled"
          class="relative left-1/2 px-5 py-3 bg-indigo-500 hover:bg-indigo-800 rounded-lg text-white"
          @click="toggleCreate"
        >
          Écrire
        </button>
        <div v-if="createIsToggled" class="max-w-3xl mx-auto sm:px-6 lg:px-8">
          <form @submit.prevent="messageStore">
            <select v-model="receiver" class="bg-indigo-100 shadow">
              <option v-for="user in users" :key="user.id" :value="user.id">
                {{ user.name }}
              </option>
            </select>
            <textarea
              v-model="content"
              placeholder="Roucouleras-tu des miaulis d'amour aujourd'hui mon patapon ?"
              class="rounded-lg border border-gray-200 w-full p-2 font-semibold resize-none focus:outline-none mt-2"
            ></textarea>
            <span class="my-5 text-red-500" v-if="$page.props.errors.content">
              {{ $page.props.errors.content }}
            </span>
            <div class="flex items-center space-x-4 justify-end mt-3">
              <button
                :disabled="receiver === 0 || content === ''"
                class="bg-blue-500 hover:bg-blue-800 rounded font-extrabold text-white p-2"
              >
                Roucouler
              </button>
            </div>
          </form>
        </div>
      </transition>
      <message-list :messages="messages"></message-list>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import MessageList from "@/Pages/Messages/List";

export default {
  components: {
    AppLayout,
    MessageList,
  },

  props: {
    messages: Array,
    users: Array,
  },

  data() {
    return {
      content: "",
      receiver: 0,
      createIsToggled: false,
    };
  },

  methods: {
    toggleCreate() {
      this.createIsToggled = !this.createIsToggled;
    },

    messageStore() {
      this.$inertia.post(
        "messages",
        { content: this.content, receiver: this.receiver },
        { preserveState: false }
      );
    },
  },
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transform: translateY(0%);

  transition: transform 0.5s ease-in-out, opacity 1s ease-in-out;
}

.fade-enter,
.fade-leave-to {
  transform: translateY(-100vh);
  opacity: 0;
}

button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>