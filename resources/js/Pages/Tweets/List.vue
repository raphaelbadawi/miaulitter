<template>
  <div
    class="max-w-3xl mx-auto sm:px-6 lg:px-8"
    @keydown.esc="unsetEditedField"
  >
    <div
      v-for="tweet in tweets"
      :key="tweet.id"
      class="flex items-center space-x-4 bg-white overflow-hidden rounded rounded-b-none border-b-2 border-gray-200 py-6 px-4"
    >
      <img
        class="h-16 w-16 object-cover rounded-full"
        :src="tweet.user.profile_photo_url"
      />
      <tweet-edit
        @tweetUpdated="unsetEditedField"
        v-if="tweet.id === isEdited"
        :tweetId="tweet.id"
        :tweetContent="tweet.content"
      >
      </tweet-edit>
      <div v-else class="flex flex-col w-2/3">
        <div>
          <a
            class="text-sm text-gray-900 font-bold hover:text-indigo-400"
            :href="`/profile/${tweet.user.name}`"
          >
            {{ tweet.user.name }}
          </a>
          <span class="font-thin text-gray-400">
            | le {{ tweet.created_at }}</span
          >
        </div>
        <div
          class="text-sm text-gray-400 font-thin"
          v-html="processTags(tweet.content)"
        ></div>
      </div>
      <div v-if="tweet.user.id !== $page.props.user.id" class="w-80">
        <button
          @click="followStore(tweet.user.id)"
          v-if="
            currentPage === 'followings'
              ? tweet.user.isFollowing
              : !tweet.user.isFollowing
          "
          class="float-right bg-white text-indigo-500 cursor-pointer px-5 py-2 hover:text-white border border-indigo-500 leading-tight hover:bg-indigo-500 rounded-full font-extrabold transition-all duration-300"
          preserve-scroll
        >
          Sentir fesses
        </button>
        <button
          @click="unfollowStore(tweet.user.id)"
          v-else
          class="float-right bg-white text-indigo-500 cursor-pointer px-5 py-2 hover:text-white border border-indigo-500 leading-tight hover:bg-indigo-500 rounded-full font-extrabold transition-all duration-300"
          preserve-scroll
        >
          Ne plus sentir fesses
        </button>
      </div>
      <div v-else class="flex float-right space-x-4">
        <transition mode="out-in" name="fade">
          <button v-if="isEdited === 0" @click="setEditedField(tweet.id)">
            <img
              src="/img/icons/interface.png"
              alt="Le plug anal"
              class="w-10"
            />
          </button>
        </transition>
        <transition mode="out-in" name="fade">
          <inertia-link
            as="button"
            method="DELETE"
            :href="`/meows/${tweet.id}`"
          >
            <img
              src="/img/icons/garbage-can.png"
              alt="La ploubelle"
              class="w-10"
            />
          </inertia-link>
        </transition>
      </div>
    </div>
  </div>
</template>

<script>
import TweetEdit from "@/Pages/Tweets/Edit";

export default {
  components: {
    TweetEdit,
  },

  props: {
    tweets: Array,
    currentPage: String,
  },

  data() {
    return {
      isEdited: 0,
    };
  },

  methods: {
    processTags(content) {
      const regex = /#[\wéèàçâêäëÉÈÀÇÂÊÄË]+/g;
      const found = content.match(regex);
      if (found) {
        for (let i = 0; i < found.length; i++) {
          content = content.replace(
            found[i],
            `<a class="text-purple-800" href="/shag/${found[i]
              .substr(1)
              .toLowerCase()}">${found[i]}</a>`
          );
        }
      }

      return content;
    },

    setEditedField(tweetId) {
      this.isEdited = tweetId;
    },

    unsetEditedField() {
      this.isEdited = 0;
    },

    followStore(userId) {
      this.$inertia.get(`/follows/${userId}`, { preserveState: true });
    },

    unfollowStore(userId) {
      this.$inertia.get(`/unfollows/${userId}`, { preserveState: true });
    },
  },
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease-in-out;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>