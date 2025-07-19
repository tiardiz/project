<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import axios from "axios";

const route = useRoute();
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

onMounted(() => {
  fetchNews();
  fetchComments();
})
const deleteComment = async (commentId) => {
  if (confirm("Удалить комментарий?")) {
    try {
      await axios.delete(`http://127.0.0.1:8000/api/comments/${commentId}`);
      fetchComments(); // Обновляем список после удаления
    } catch (error) {
      console.error("Ошибка при удалении комментария:", error);
    }
  }
};
</script>

<template>
  <div class="container mx-auto px-4 py-6" v-if="newsItem">
    <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ newsItem.title }}</h2>
    <img :src="newsItem.image" alt="News Image" class="w-full h-64 object-cover mb-4" />
    <p class="text-gray-700 mb-6">{{ newsItem.text }}</p>

    <div class="bg-gray-100 p-4 rounded-md">
      <h3 class="text-lg font-semibold mb-2">Комментарии:</h3>
      <ul class="space-y-2 mb-4">
        <li
  v-for="comment in comments"
  :key="comment.id"
  class="text-sm text-gray-800 border-b pb-1 flex justify-between items-center"
>
  <span>{{ comment.content }}</span>
  <button
    @click="deleteComment(comment.id)"
    class="text-red-500 text-xs hover:underline"
  >
    удалить
  </button>
</li>

      </ul>

      <form @submit.prevent="addComment" class="flex gap-2">
        <input
          v-model="newComment"
          placeholder="Ваш комментарий"
          class="flex-1 p-2 border rounded-md"
        />
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">
          Отправить
        </button>
      </form>
    </div>
  </div>
</template>
