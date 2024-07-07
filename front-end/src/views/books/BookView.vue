<template>
  <div class="container mx-auto">
    <div class="md:mx-60">
      <div class="flex flex-row-reverse">
        <button @click="getBack" class="">Get back</button>
      </div>

      <!-- Loading indicator -->
      <div v-if="isLoading" class="bg-gray-200 flex justify-center py-2 rounded-lg">
        Loading...
      </div>
      <!-- Book details -->
      <div v-else class="bg-gray-200 p-2 m-2 rounded-lg space-y-4">
        <img v-if="book.image_path" class="h-96 w-full rounded-lg" :src="imagePath + book.image_path" alt="Book Cover">
        <h1 class="text-lg">{{ book.title }}</h1>
        <h2 class="text-lg">{{ book.created_at }}</h2>
        <!-- WhatsApp button -->
        <a v-if="book.user" aria-label="Chat on WhatsApp"
          :href="'https://wa.me/' + book.user.phone_number + '?text=' + message">
          <Button class="w-full" color="green">تواصل على الواتس</Button>
        </a>
      </div>

      <!-- Publisher details -->
      <div v-if="book.user" class="bg-gray-200 p-2 m-2 rounded-lg space-y-4">
        <h1 class="text-lg">اسم الناشر : {{ book.user.name }}</h1>
      </div>

      <!-- Book level details -->
      <div class="bg-gray-200 p-2 m-2 rounded-lg space-y-4">
        <h1 class="text-lg">مرحلة الكتاب: {{ bookLevelText }}</h1>
      </div>

      <!-- Status details -->
      <div class="bg-gray-200 p-2 m-2 rounded-lg space-y-4">
        <h1 class="text-lg">حالة العرض: {{ statusText }}</h1>
      </div>

    </div>
  </div>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router'
import Button from '@/components/Button.vue'
import { onMounted, ref, computed } from 'vue'
import { fetchBook } from '@/services/bookService';
const route = useRoute()
const router = useRouter()
const bookId = route.params.id
const imagePath = import.meta.env.VITE_IMAGE_PATHS
const book = ref({})
const isLoading = ref(true)
const message = 'مرحبا%20لقد وجدت%20اعلانك%20عن%20طريق%20موقع%20تبادل'

// Function to fetch book details from the server
async function getBook(id) {

  const bookResult = await fetchBook(id)

  if (bookResult.status === 201) {
    book.value = bookResult.data[0]
    isLoading.value = false
  } else {
    toast.error('An unknown error occurred.', { "theme": "colored" });
  }

}

function getBack() {
  router.back()
}

// Computed properties
const bookLevelText = computed(() => {
  switch (book.value.book_level) {
    case 1:
      return 'دبلوم';
    case 2:
      return 'بكالوريوس';
    default:
      return 'غير معروفة';
  }
});

const statusText = computed(() => {
  switch (book.value.status) {
    case 1:
      return 'معروض';
    case 2:
      return 'مطلوب';
    default:
      return 'غير محددة';
  }
});


// Fetch book details when component is mounted
onMounted(() => {
  getBook(bookId)
})
</script>