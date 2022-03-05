<template>
  <button
    class="
      px-2
      inline-flex
      text-xs
      leading-5
      font-semibold
      rounded-full
      bg-green-100
      text-green-800 text-indigo-600
      hover:text-indigo-900
    "
    @click="toggleProgress()"
  >
    Terminer
  </button>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  props: ["episodeId", "watchedEpisodes"],
  data() {
    return {
      watchedEp: this.watchedEpisodes,
    };
  },
  methods: {
    toggleProgress() {
      axios
        .post("/toggleProgress", {
          episodeId: this.episodeId,
        })
        .then((result) => {
          console.log(result);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    mounted() {
      console.log(this.watchedEp);
    },
  },
});
</script>