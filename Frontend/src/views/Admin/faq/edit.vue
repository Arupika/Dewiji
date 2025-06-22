<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import api from '@/api'

const router = useRouter()
const route = useRoute()

const title = ref('')
const answer = ref('')
const category = ref('')
const errors = ref({})
const successMessage = ref('')

onMounted(async () => {
  try {
    const res = await api.get(`/api/faqs/${route.params.id}`)
    const data = res.data.data
    title.value = data.title
    answer.value = data.answer
    category.value = data.category
  } catch (err) {
    console.error(err)
  }
})

const updateFaq = async () => {
  errors.value = {}
  try {
    const res = await api.patch(`/api/faqs/${route.params.id}`, {
      title: title.value,
      answer: answer.value,
      category: category.value
    })
    successMessage.value = res.data.message || 'FAQ berhasil diperbarui!'
    setTimeout(() => router.push('/admin/Dashboard'), 1500)
  } catch (err) {
    errors.value = err.response?.data || {}
  }
}
</script>

<template>
  <div class="container mt-5">
    <h3 class="mb-3">Edit FAQ</h3>

    <div v-if="successMessage" class="alert alert-success">
      {{ successMessage }}
    </div>

    <form @submit.prevent="updateFaq">
      <div class="mb-3">
        <label class="form-label">Judul</label>
        <input v-model="title" class="form-control" placeholder="Masukkan judul pertanyaan" />
        <small class="text-danger" v-if="errors.title">{{ errors.title[0] }}</small>
      </div>

      <div class="mb-3">
        <label class="form-label">Jawaban</label>
        <textarea v-model="answer" class="form-control" rows="4" placeholder="Masukkan jawaban"></textarea>
        <small class="text-danger" v-if="errors.answer">{{ errors.answer[0] }}</small>
      </div>

      <div class="mb-3">
        <label class="form-label">Kategori</label>
        <input v-model="category" class="form-control" placeholder="Contoh: Umum" />
        <small class="text-danger" v-if="errors.category">{{ errors.category[0] }}</small>
      </div>

      <button class="btn btn-primary">Update</button>
    </form>
  </div>
</template>
