<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/api'

const router = useRouter()

const title = ref('')
const answer = ref('')
const category = ref('')
const errors = ref({})
const successMessage = ref('')

const storeFaq = async () => {
  errors.value = {}
  try {
    const response = await api.post('/api/faqs', {
      title: title.value,
      answer: answer.value,
      category: category.value
    })
    successMessage.value = response.data.message || 'FAQ berhasil disimpan!'
    setTimeout(() => {
      router.push('/admin/Dashboard')
    }, 1500)
  } catch (error) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data
    } else {
      alert('Terjadi kesalahan server.')
    }
  }
}
</script>

<template>
  <div class="container mt-5">
    <h3 class="mb-3">Tambah FAQ</h3>

    <div v-if="successMessage" class="alert alert-success">
      {{ successMessage }}
    </div>

    <form @submit.prevent="storeFaq">
      <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" class="form-control" v-model="title" />
        <small class="text-danger" v-if="errors.title">{{ errors.title[0] }}</small>
      </div>

      <div class="mb-3">
        <label class="form-label">Jawaban</label>
        <textarea class="form-control" v-model="answer" rows="4"></textarea>
        <small class="text-danger" v-if="errors.answer">{{ errors.answer[0] }}</small>
      </div>

      <div class="mb-3">
        <label class="form-label">Kategori</label>
        <input type="text" class="form-control" v-model="category" />
        <small class="text-danger" v-if="errors.category">{{ errors.category[0] }}</small>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</template>
