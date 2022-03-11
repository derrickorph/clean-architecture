<template>
  <div class="bg-gray-200 w-full rounded">
    <div
      class="
        bg-green-500
        text-white
        rounded-l
        py-3
        text-center
        transition-width
        duration-500
      "
      :style="'width:' + percentage + '%'"
    >
      {{ percentage }}%
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  props: ["watchedEpisodes", "episodes"],
  data() {
    return {
      watchedEpisodesData: this.watchedEpisodes,
    };
  },
  computed: {
    percentage() {
      let filteredEp = this.episodes.filter((courseEp) => {
        return this.watchedEpisodesData.find((watchedEp) => {
          return watchedEp.id == courseEp.id;
        });
      });
      return Math.ceil((filteredEp.length / this.episodes.length) * 100);
    },
  },
  methods: {},

  mounted() {
    // mitt.on("foo", (e) => console.log("foo", e));
    mitt.on("toggleProgress", (data) => {
      this.watchedEpisodesData = data;
    });
  },
});
</script>
