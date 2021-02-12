<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Les culs que j'aime
      </h2>
    </template>

    <div class="py-12">
      <tweet-list
        v-if="followings.length !== 0"
        :tweets="followings"
        :currentPage="currentPage"
      ></tweet-list>
        <p v-else class="mx-auto bg-white rounded-lg p-10 w-1/2 text-center text-lg">
          Vous ne suivez aucun cul ! Quel brame ! drame.
        </p>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import TweetList from "@/Pages/Tweets/List";

export default {
  props: {
    followings: null,
  },

  components: {
    AppLayout,
    TweetList,
  },

  data() {
    return {
      currentPage: "followings",
    };
  },
};
</script>
