<template>
  <app-layout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Modification de {{ courseData.title }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div
          class="
            bg-white
            sm:px-6
            lg:px-8
            sm:py-6
            lg:py-8
            overflow-hidden
            shadow-xl
            sm:rounded-lg
          "
        >
          <form @submit.prevent="submit">
            <div>
              <jet-label for="title" value="Titre de la formation" />
              <jet-input
                id="title"
                type="text"
                class="mt-1 block w-full"
                autofocus
                v-model="courseData.title"
              />
              <div class="my-1">
                <jet-input-error v-if="errors.title" class="text-red-600">
                  {{ errors.title }}
                </jet-input-error>
              </div>
            </div>

            <div class="mt-4">
              <jet-label
                for="description"
                value="Description de la formation"
              />
              <textarea
                id="description"
                class="
                  mt-1
                  block
                  border-gray-300
                  focus:border-indigo-300
                  focus:ring
                  focus:ring-indigo-200
                  focus:ring-opacity-50
                  rounded-md
                  shadow-sm
                  w-full
                "
                v-model="courseData.description"
                rows="3"
              ></textarea>
              <div class="my-1">
                <jet-input-error v-if="errors.description" class="text-red-600">
                  {{ errors.description }}
                </jet-input-error>
              </div>
            </div>
            <div class="mt-4">
              <h2 class="text-2xl">Episodes de la formation</h2>
              <div
                v-for="(episode, index) in courseData.episodes"
                v-bind:key="index"
              >
                <div class="mt-4">
                  <jet-label
                    :for="'title-' + index"
                    :value="'Titre de l\'épisode n°' + (index + 1)"
                  />
                  <jet-input
                    :id="'title-' + index"
                    type="text"
                    class="mt-1 block w-full"
                    autofocus
                    v-model="courseData.episodes[index].title"
                  />
                  <div class="my-1">
                    <jet-input-error
                      v-if="errors['episodes.' + index + '.title']"
                      class="text-red-600"
                    >
                      {{ errors["episodes." + index + ".title"] }}
                    </jet-input-error>
                  </div>
                </div>
                <div class="mt-4">
                  <jet-label
                    :for="'video_url-' + index"
                    :value="'URL de la vidéo de l\'épisode n°' + (index + 1)"
                  />
                  <jet-input
                    :id="'video_url-' + index"
                    type="url"
                    class="mt-1 block w-full"
                    autofocus
                    v-model="courseData.episodes[index].video_url"
                  />
                  <div class="my-1">
                    <jet-input-error
                      v-if="errors['episodes.' + index + '.video_url']"
                      class="text-red-600"
                    >
                      {{ errors["episodes." + index + ".video_url"] }}
                    </jet-input-error>
                  </div>
                </div>
                <div class="mt-4">
                  <jet-label
                    :for="'description-' + index"
                    :value="'Description de l\'épisode n°' + (index + 1)"
                  />
                  <textarea
                    :id="'description-' + index"
                    class="
                      mt-1
                      block
                      border-gray-300
                      focus:border-indigo-300
                      focus:ring
                      focus:ring-indigo-200
                      focus:ring-opacity-50
                      rounded-md
                      shadow-sm
                      w-full
                      mb-4
                    "
                    v-model="courseData.episodes[index].description"
                    rows="3"
                  ></textarea>
                  <div class="my-1">
                    <jet-input-error
                      v-if="errors['episodes.' + index + '.description']"
                      class="text-red-600"
                    >
                      {{ errors["episodes." + index + ".description"] }}
                    </jet-input-error>
                  </div>
                </div>
              </div>
            </div>
            <jet-button
              v-if="courseData.episodes.length < 15"
              class="bg-green-600 mt-2 mx-3"
              @click.prevent="add"
            >
              +
            </jet-button>
            <jet-button
              v-if="courseData.episodes.length > 1"
              class="bg-red-600 mt-2"
              @click.prevent="remove"
            >
              -
            </jet-button>

            <div class="flex items-center justify-end mt-4">
              <jet-button
                class="ml-4"
                :class="{ 'opacity-25': courseData.processing }"
                :disabled="courseData.processing"
              >
                Modifier une formation
              </jet-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetInputError from "@/Jetstream/InputError.vue";
export default defineComponent({
  props: {
    errors: Object,
    course: Object,
  },
  components: {
    AppLayout,
    Welcome,
    JetButton,
    JetInput,
    JetLabel,
    JetInputError,
  },
  data() {
    return {
      courseData: this.course,
    };
  },
  methods: {
    submit() {
      this.$inertia.patch(
        "/course/edit/" + this.courseData.id,
        this.courseData
      );
    },
    add() {
      this.courseData.episodes.push({
        title: null,
        description: null,
        video_url: null,
      });
    },
    remove() {
      this.courseData.episodes.pop();
    },
  },
});
</script>
