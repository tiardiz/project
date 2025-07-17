<script setup>
import { ref, computed } from "vue";

const allNews = ref([
  {
    image: "https://via.placeholder.com/600x300",
    title: "Новость 1",
    text: "Краткое описание новости 1.",
  },
  {
    image: "https://via.placeholder.com/600x300",
    title: "Новость 2",
    text: "Краткое описание новости 2.",
  },
  {
    image: "https://via.placeholder.com/600x300",
    title: "Новость 3",
    text: "Краткое описание новости 3.",
  },
  // Добавь больше новостей при желании
]);

const currentPage = ref(1);
const pageSize = 2;

const totalPages = computed(() => Math.ceil(allNews.value.length / pageSize));

const paginatedNews = computed(() =>
  allNews.value.slice(
    (currentPage.value - 1) * pageSize,
    currentPage.value * pageSize
  )
);
</script>

<template>
  <div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">News:</h2>

    <!-- Карточки новостей -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="(news, index) in paginatedNews"
        :key="index"
        class="bg-white rounded-2xl shadow-md overflow-hidden"
      >
        <img
          :src="news.image"
          alt="news image"
          class="w-full h-48 object-cover"
        />
        <div class="p-4">
          <h3 class="text-xl font-semibold text-gray-900 mb-2">
            {{ news.title }}
          </h3>
          <p class="text-gray-700 text-sm">{{ news.text }}</p>
        </div>
      </div>
    </div>

    <!-- Пагинация -->
    <div class="flex justify-center mt-8 space-x-2">
      <button
        v-for="page in totalPages"
        :key="page"
        @click="currentPage = page"
        class="px-4 py-2 rounded-md border border-gray-300"
        :class="{
          'bg-blue-600 text-white': currentPage === page,
          'hover:bg-gray-200': currentPage !== page,
        }"
      >
        {{ page }}
      </button>
    </div>
  </div>
</template>
