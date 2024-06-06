<template>
  <div class="container mx-auto">
    <div class="md:mx-60">
      <div class="flex flex-row-reverse">
        <button @click="bb">Get back</button>
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
          :href="'https://wa.me/' + book.user.phone_number + '?' + message">
          <Button class="w-full" color="green">تواصل على الواتس</Button>
        </a>
      </div>
      <!-- Publisher details -->
      <div v-if="book.user" class="bg-gray-200 p-2 m-2 rounded-lg space-y-4">
        <h1 class="text-lg">اسم الناشر : {{ book.user.name }}</h1>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRoute,useRouter } from 'vue-router'
import Button from '@/components/Button.vue'
import { onMounted, ref } from 'vue'
import { fetchBook } from '@/services/bookService';
const route = useRoute()
const router = useRouter()
const bookId = route.params.id
const imagePath = import.meta.env.VITE_IMAGE_PATHS
const book = ref({})
const isLoading = ref(true)
const message = 'test'

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

function bb(){
  router.back()
}


// Fetch book details when component is mounted
onMounted(() => {
  getBook(bookId)
})
</script>