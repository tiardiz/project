<script setup>
import { ref, computed, onMounted } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

const router = useRouter();
const allNews = ref([]);
const currentPage = ref(1);
const pageSize = 9;

const newNews = ref({ title: "", body: "", image: "", author: "" });

const totalPages = computed(() => Math.ceil(allNews.value.length / pageSize));
const paginatedNews = computed(() =>
  allNews.value.slice(
    (currentPage.value - 1) * pageSize,
    currentPage.value * pageSize
  )
);

const fetchNews = async () => {
  try {
    const response = await axios.get("http://127.0.0.1:8000/api/news");
    allNews.value = response.data;
  } catch (error) {
    console.error("Ошибка при загрузке новостей:", error);
  }
};

onMounted(() => fetchNews());

const isLoading = ref(false);
const errorMessage = ref("");

const addNews = async () => {
  if (!newNews.value.title || !newNews.value.body || !newNews.value.author || !newNews.value.image) {
    errorMessage.value = "Заполните все поля.";
    return;
  }

  try {
    isLoading.value = true;
    errorMessage.value = "";
    await axios.post("http://127.0.0.1:8000/api/news", newNews.value);
    newNews.value = { title: "", body: "", image: "" };
    await fetchNews();
  } catch (error) {
    console.error("Ошибка при добавлении новости:", error);
    errorMessage.value = "Не удалось добавить новость.";
  } finally {
    isLoading.value = false;
  }
};

const deleteNews = async (id) => {
  if (confirm("Удалить эту новость?")) {
    try {
      await axios.delete(`http://localhost:8000/api/news/${id}`);
      allNews.value = allNews.value.filter(n => n.id !== id); // обновление списка
    } catch (error) {
      console.error("Ошибка при удалении:", error);
    }
  }
};

const goToNews = (id) => {
  router.push(`/news/${id}`);
};

const likeNews = async (id) => {
  try {
    await axios.post(`http://127.0.0.1:8000/api/news/${id}/like`);
    fetchNews(); // обновить список после лайка
  } catch (error) {
    console.error("Ошибка при лайке:", error);
  }
};

</script>

<template>
  <div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">
      News:
    </h2>
    <!-- Добавление новости -->
    <form
      class="mb-6 space-y-4 bg-gray-100 p-4 rounded-md"
      @submit.prevent="addNews"
    >
      <div
        v-if="errorMessage"
        class="text-red-500 text-sm"
      >
        {{ errorMessage }}
      </div>

      <input
        v-model="newNews.title"
        placeholder="Title"
        class="w-full p-2 border rounded-md"
        required
      >
      <textarea
        v-model="newNews.body"
        placeholder="Text"
        class="w-full p-2 border rounded-md"
        required
      />
      <input
        v-model="newNews.author"
        placeholder="Author"
        class="w-full p-2 border rounded-md"
        required
      >

      <input
        v-model="newNews.image"
        placeholder="Image URL"
        class="w-full p-2 border rounded-md"
      >
      <button
        type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded-md"
        :disabled="isLoading"
      >
        {{ isLoading ? "Добавление..." : "Добавить новость" }}
      </button>
    </form>


    <!-- Список новостей -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="news in paginatedNews"
        :key="news.id"
        class="bg-white rounded-2xl shadow-md overflow-hidden relative group cursor-pointer flex flex-col"
        style="height: 380px"
        @click="goToNews(news.id)"
      >
        <img
          :src="news.image"
          alt="news image"
          class="w-full h-48 object-cover"
        >
        <div class="p-4 flex-1 flex flex-col justify-between">
          <div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">
              {{ news.title }}
            </h3>
            <p
              class="text-gray-700 text-sm overflow-hidden line-clamp-3"
            >
              {{ news.body }}
            </p>
          </div>

          <!-- Лайки и просмотры -->
          <div class="flex justify-between items-center mt-4 text-sm text-gray-500">
            <span class="inline-flex items-center gap-1">
              <svg
                class="w-6 h-6 text-gray-800 dark:text-white"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  fill-rule="evenodd"
                  d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                  clip-rule="evenodd"
                />
              </svg> {{ news.views }}</span>
            <button
              class="inline-flex items-center gap-1"
              @click.stop="likeNews(news.id)"
            >
              <svg
                class="w-6 h-6 text-gray-800 dark:text-white"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="currentColor"
                viewBox="0 0 24 24"
              >
                <path d="m12.75 20.66 6.184-7.098c2.677-2.884 2.559-6.506.754-8.705-.898-1.095-2.206-1.816-3.72-1.855-1.293-.034-2.652.43-3.963 1.442-1.315-1.012-2.678-1.476-3.973-1.442-1.515.04-2.825.76-3.724 1.855-1.806 2.201-1.915 5.823.772 8.706l6.183 7.097c.19.216.46.34.743.34a.985.985 0 0 0 .743-.34Z" />
              </svg> {{ news.likes }}
            </button>
          </div>
        </div>

        <button
          class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-md text-xs opacity-0 group-hover:opacity-100"
          @click.stop="deleteNews(news.id)"
        >
          Удалить
        </button>
      </div>
    </div>


    <!-- Пагинация -->
    <div class="flex justify-center mt-8 space-x-2">
      <button
        v-for="page in totalPages"
        :key="page"
        class="px-4 py-2 rounded-md border border-gray-300"
        :class="{
          'bg-blue-600 text-white': currentPage === page,
          'hover:bg-gray-200': currentPage !== page,
        }"
        @click="currentPage = page"
      >
        {{ page }}
      </button>
    </div>
  </div>
</template>