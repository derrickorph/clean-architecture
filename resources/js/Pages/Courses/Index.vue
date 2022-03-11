<template>
  <app-layout title="Courses">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Liste des formations
      </h2>
    </template>
    <div
      v-if="$page.props.flash.success"
      class="bg-green-200 mx-8 text-green-500 shadow p-3 my-3"
    >
      {{ $page.props.flash.success }}
    </div>

    <section>
      <div
        class="py-3"
        v-for="course in this.courseList.data"
        v-bind:key="course.id"
      >
        <div class="mx-8 bg-white rounded shadow p-4">
          <div class="text-sm text-gray-500">
            Mise en ligne par : {{ course.user.name }} -
            <span class="text-gray-500 text-sm">
              {{ course.participants }} participant<span
                v-if="parseInt(course.participants) > 1"
                >s</span
              >
            </span>
          </div>

          <div class="flex justify-between items-center">
            <div class="text-4xl">{{ course.title }}</div>
            <div class="text-sm text-gray-400">
              {{ course.episodes_count }} épisodes
            </div>
          </div>
          <div class="text-sm text-gray-500">{{ course.description }}</div>
          <div class="flex items-center justify-between">
            <Link
              :href="'course/' + course.id"
              class="
                bg-indigo-500
                text-white
                px-2
                py-1
                text-sm
                mt-3
                inline-block
                rounded
                hover:bg-indigo-700
              "
              
            >
              Voir la formation
            </Link>
            <Link
              :href="'course/edit/' + course.id"
              v-if="course.permission"
              class="
                bg-gray-500
                text-white
                px-2
                py-1
                text-sm
                mt-3
                inline-block
                rounded
                hover:bg-gray-700
              "
            >
              Modifier la formation
            </Link>
          </div>
        </div>
      </div>
      <jet-pagination class="mt-6 mx-8" :links="this.courseList.links" />
    </section>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetPagination from "@/Jetstream/Pagination.vue";
import { Link } from '@inertiajs/inertia-vue3'
export default defineComponent({
  components: {
    AppLayout,
    JetPagination,
    Link,
  },
  props: ["courses"],

  data() {
    return {
      courseList: this.courses,
    };
  },
  mounted() {
    console.log("Success");
  },
});
</script>
