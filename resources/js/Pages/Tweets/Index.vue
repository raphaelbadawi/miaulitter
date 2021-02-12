<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ title }}
      </h2>
    </template>

    <tweet-create :tweets="tweets" :currentPage="currentPage"></tweet-create>

    <div class="py-12">
      <tweet-list :tweets="tweets"></tweet-list>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import TweetCreate from "@/Pages/Tweets/Create";
import TweetList from "@/Pages/Tweets/List";

export default {
  props: {
    tweets: Array,
    shag: null,
  },

  components: {
    AppLayout,
    TweetCreate,
    TweetList,
  },

  data() {
    return {
      currentPage: "index",
    };
  },

  computed: {
    title() {
      return this.shag ? `Miaulis shaggés #${this.shag}` : "Derniers miaulis";
    },
  },
};
</script>
