<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/api'

const router = useRouter()

const name = ref('')
const email = ref('')
const phone = ref('')
const birthDate = ref('')
const role = ref('user')
const sex = ref('')
const address = ref('')
const password = ref('')
const agreeTerms = ref(false)
const gambar = ref(null)

const errors = ref({})
const successMessage = ref('')

const handleFileChange = (e) => {
  const file = e.target.files[0]
  if (file && file.type.startsWith('image/')) {
    gambar.value = file
  } else {
    gambar.value = null
  }
}

const storeUser = async () => {
  errors.value = {}

  if (!agreeTerms.value) {
    errors.value.agreeTerms = ['Anda harus menyetujui syarat & ketentuan.']
    return
  }

  const formData = new FormData()
  formData.append('name', name.value)
  formData.append('email', email.value)
  formData.append('phone', phone.value)
  formData.append('birthDate', birthDate.value)
  formData.append('role', role.value)
  formData.append('sex', sex.value)
  formData.append('address', address.value)
  formData.append('password', password.value)
  formData.append('agreeTerms', '1') // harus string '1'
  if (gambar.value) formData.append('gambar', gambar.value)

  try {
    const res = await api.post('/api/users', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    successMessage.value = res.data.message || 'User berhasil ditambahkan!'
    setTimeout(() => router.push('/Admin/Dashboard'), 1500)
  } catch (err) {
    errors.value = err.response?.data || {}
  }
}
</script>

<template>
  <div class="container mt-5">
    <h3 class="mb-3">Tambah User</h3>

    <div v-if="successMessage" class="alert alert-success">
      {{ successMessage }}
    </div>

    <form @submit.prevent="storeUser">
      <div class="mb-3">
        <label>Nama</label>
        <input v-model="name" class="form-control" />
        <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
      </div>

      <div class="mb-3">
        <label>Email</label>
        <input v-model="email" type="email" class="form-control" />
        <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
      </div>

      <div class="mb-3">
        <label>Nomor HP</label>
        <input v-model="phone" class="form-control" />
        <small class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
      </div>

      <div class="mb-3">
        <label>Tanggal Lahir</label>
        <input v-model="birthDate" type="date" class="form-control" />
        <small class="text-danger" v-if="errors.birthDate">{{ errors.birthDate[0] }}</small>
      </div>

      <div class="mb-3">
        <label>Role</label>
        <select v-model="role" class="form-control">
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
        <small class="text-danger" v-if="errors.role">{{ errors.role[0] }}</small>
      </div>

      <div class="mb-3">
        <label>Jenis Kelamin</label>
        <select v-model="sex" class="form-control">
          <option value="">Pilih</option>
          <option value="male">Laki-laki</option>
          <option value="female">Perempuan</option>
        </select>
        <small class="text-danger" v-if="errors.sex">{{ errors.sex[0] }}</small>
      </div>

      <div class="mb-3">
        <label>Alamat</label>
        <textarea v-model="address" class="form-control" rows="2"></textarea>
        <small class="text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
      </div>

      <div class="mb-3">
        <label>Password</label>
        <input v-model="password" type="password" class="form-control" />
        <small class="text-danger" v-if="errors.password">{{ errors.password[0] }}</small>
      </div>

      <div class="mb-3">
        <label>Foto Profil</label>
        <input type="file" class="form-control" @change="handleFileChange" />
        <small class="text-danger" v-if="errors.gambar">{{ errors.gambar[0] }}</small>
      </div>

      <div class="mb-3 form-check">
        <input type="checkbox" v-model="agreeTerms" class="form-check-input" id="termsCheck" />
        <label class="form-check-label" for="termsCheck">Saya menyetujui syarat & ketentuan</label>
        <br />
        <small class="text-danger" v-if="errors.agreeTerms">{{ errors.agreeTerms[0] }}</small>
      </div>

      <button class="btn btn-primary">Simpan</button>
    </form>
  </div>
</template>
