<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import axios from "axios";

const route = useRoute();
const router = useRouter();
const newsId = route.params.id;

const newsItem = ref(null);
const comments = ref([]);
const newComment = ref("");

const fetchNews = async () => {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/news/${newsId}`);
    newsItem.value = response.data;
  } catch (error) {
    console.error("Ошибка при загрузке новости:", error);
  }
};

const fetchComments = async () => {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/news/${newsId}/comments`);
    comments.value = response.data;
  } catch (error) {
    console.error("Ошибка при загрузке комментариев:", error);
  }
};

const addComment = async () => {
  try {
    await axios.post(`http://127.0.0.1:8000/api/news/${newsId}/comments`, {
      content: newComment.value,
    });
    newComment.value = "";
    fetchComments();
  } catch (error) {
    console.error("Ошибка при добавлении комментария:", error);
  }
};

const deleteComment = async (commentId) => {
  if (confirm("Удалить комментарий?")) {
    try {
      await axios.delete(`http://127.0.0.1:8000/api/comments/${commentId}`);
      fetchComments();
    } catch (error) {
      console.error("Ошибка при удалении комментария:", error);
    }
  }
};

onMounted(() => {
  fetchNews();
  fetchComments();
});
</script>

<template>
  <div
    v-if="newsItem"
    class="container mx-auto px-4 py-6"
  >
    <!-- 🔙 Назад -->
    <button
      class="mb-4 text-blue-600 hover:underline text-sm"
      @click="router.push('/')"
    >
      ← На главную
    </button>

    <!-- 🕓 Дата -->
    <p class="text-sm text-gray-500 mb-1">
      Опубликовано: {{ new Date(newsItem.created_at).toLocaleString() }}
    </p>

    <!-- 🖼 Заголовок и изображение -->
    <h2 class="text-3xl font-bold text-gray-800 mb-4">
      {{ newsItem.title }}
    </h2>
    <img
      :src="newsItem.image"
      alt="News Image"
      class="w-50 h-64 object-cover rounded-lg mb-4"
    >

    <p class="text-gray-700 text-lg mb-6">
      {{ newsItem.body }}
    </p>
    <p class="text-sm text-gray-500 italic mb-6">
      Автор: {{ newsItem.author }}
    </p>

    <!-- ❤️ Лайки и 👁 Просмотры -->
    <div class="flex justify-end items-center gap-4 text-sm text-gray-500 mb-8">
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
        </svg>
        {{ newsItem.views }}</span>
      <span class="inline-flex items-center gap-1">  <svg
        class="w-6 h-6 text-gray-800 dark:text-white"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        fill="currentColor"
        viewBox="0 0 24 24"
      >
        <path d="m12.75 20.66 6.184-7.098c2.677-2.884 2.559-6.506.754-8.705-.898-1.095-2.206-1.816-3.72-1.855-1.293-.034-2.652.43-3.963 1.442-1.315-1.012-2.678-1.476-3.973-1.442-1.515.04-2.825.76-3.724 1.855-1.806 2.201-1.915 5.823.772 8.706l6.183 7.097c.19.216.46.34.743.34a.985.985 0 0 0 .743-.34Z" />
      </svg>{{ newsItem.likes }}</span>
    </div>

    <!-- 💬 Комментарии -->
    <div class="bg-gray-100 p-4 rounded-md">
      <h3 class="text-lg font-semibold mb-2">
        Комментарии:
      </h3>

      <ul class="space-y-2 mb-4">
        <li
          v-for="comment in comments"
          :key="comment.id"
          class="text-sm text-gray-800 border-b pb-1 flex justify-between items-center"
        >
          <span>{{ comment.content }}</span>
          <button
            class="text-red-500 text-xs hover:underline"
            @click="deleteComment(comment.id)"
          >
            удалить
          </button>
        </li>
      </ul>

      <!-- ➕ Добавление комментария -->
      <form
        class="flex gap-2"
        @submit.prevent="addComment"
      >
        <input
          v-model="newComment"
          placeholder="Ваш комментарий"
          class="flex-1 p-2 border rounded-md"
        >
        <button
          type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded-md"
        >
          Отправить
        </button>
      </form>
    </div>
  </div>
</template>
