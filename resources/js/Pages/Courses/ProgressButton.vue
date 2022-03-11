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
    {{ this.isWatched ? "Terminer" : "Terminer ?" }}
  </button>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  props: ["episodeId", "watchedEpisodes"],
  data() {
    return {
      watchedEp: this.watchedEpisodes,
      isWatched: null,
    };
  },
  methods: {
    toggleProgress() {
      axios
        .post("/toggleProgress", {
          episodeId: this.episodeId,
        })
        .then((response) => {
          if (response.status == 200) {
            this.isWatched = !this.isWatched;
            // mitt.emit("foo", response.data);
            mitt.emit("toggleProgress", response.data);
          }
          console.log("OK");
        })
        .catch((err) => {
          console.log(err);
        });
    },
    isWatchedEpisode() {
      return this.watchedEp.find((episode) => episode.id === this.episodeId)
        ? true
        : false;
    },
  },
  mounted() {
    this.isWatched = this.isWatchedEpisode();
  },
});
</script>
