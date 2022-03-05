<template>
  <app-layout title="Détail formation">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ this.courseShow.title }}
      </h2>
    </template>

    <div class="py-3 mx-8">
      <div class="mt-2 bg-white rounded shadow p-4">
        <div class="text-2xl">
          {{ this.courseShow.episodes[this.currentKey].title }}
        </div>
      </div>
      <div class="mt-2 bg-white rounded shadow p-24">
        <iframe
          class="w-full h-screen"
          :src="this.courseShow.episodes[this.currentKey].video_url"
          :title="this.courseShow.episodes[this.currentKey].title"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen
        ></iframe>
      </div>

      <div class="mt-2 bg-white rounded shadow p-4">
        <div class="text-sm text-gray-500">
          {{ this.courseShow.episodes[this.currentKey].description }}
        </div>
      </div>

      <div class="mt-6">
        <div class="flex flex-col">
          <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div
              class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
            >
              <div
                class="
                  shadow
                  overflow-hidden
                  border-b border-gray-200
                  sm:rounded-lg
                "
              >
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th
                        scope="col"
                        class="
                          px-6
                          py-3
                          text-left text-xs
                          font-medium
                          text-gray-500
                          uppercase
                          tracking-wider
                        "
                      >
                        Title
                      </th>
                      <th scope="col" class="relative px-6 py-3"></th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr
                      v-for="(episode, index) in this.courseShow.episodes"
                      :key="episode.id"
                    >
                      <td
                        class="
                          px-6
                          py-4
                          whitespace-nowrap
                          text-sm text-gray-500
                        "
                      >
                        Episode n° {{ index + 1 }}- {{ episode.title }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <button
                          class="
                            px-2
                            inline-flex
                            text-xs
                            leading-5
                            font-semibold
                            rounded-full
                            bg-purple-500
                            text-white
                            focus:text-indigo-600 focus:outline-none
                            hover:text-indigo-900
                            mx-2
                          "
                          @click="switchepisode(index)"
                        >
                          Voir l'épisode
                        </button>
                        <progress-button
                          :episode-id="episode.id"
                          :watched-episodes="watched"
                        />
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import ProgressButton from "./ProgressButton.vue";

export default defineComponent({
  components: {
    AppLayout,
    ProgressButton,
  },
  props: ["course", "watched"],

  data() {
    return {
      courseShow: this.course,
      currentKey: 0,
    };
  },
  methods: {
    switchepisode(index) {
      this.currentKey = index;
      window.scrollTo({
        top: 0,
        left: 0,
        behavior: "smooth",
      });
    },
  },
  mounted() {
    console.log(this.watched);
  },
});
</script>
