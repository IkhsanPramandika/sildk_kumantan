<template>
  <GuestLayout title="Hubungi Kami">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-red-600 to-red-800 text-white py-16 md:py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Hubungi Kami</h1>
            <p class="text-xl text-red-100 opacity-90">Silakan hubungi kami untuk informasi lebih lanjut atau pertanyaan</p>
        </div>
    </div>
</div>

    <!-- Contact Info & Form Section -->
    <section class="py-16 bg-white">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
          <!-- Contact Information -->
          <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Kontak</h2>

            <div class="space-y-6">
              <div class="flex items-start">
                <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                  <MapPinIcon class="w-6 h-6 text-blue-600" />
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-semibold text-gray-900">Alamat</h3>
                  <p class="text-gray-700 mt-1">
                    {{ villageProfile.address || 'Alamat belum ditambahkan' }}
                    <span v-if="villageProfile.rt && villageProfile.rw">
                      RT {{ villageProfile.rt }}/RW {{ villageProfile.rw }}
                    </span>
                  </p>
                  <p v-if="villageProfile.district || villageProfile.city || villageProfile.province" class="text-gray-600">
                    {{ [villageProfile.district, villageProfile.city, villageProfile.province].filter(Boolean).join(', ') }}
                    <span v-if="villageProfile.postal_code">{{ villageProfile.postal_code }}</span>
                  </p>
                </div>
              </div>

              <div class="flex items-start">
                <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                  <PhoneIcon class="w-6 h-6 text-blue-600" />
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-semibold text-gray-900">Telepon</h3>
                  <p class="text-gray-700 mt-1">{{ villageProfile.phone || 'Nomor telepon belum ditambahkan' }}</p>
                </div>
              </div>

              <div class="flex items-start">
                <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                  <EnvelopeIcon class="w-6 h-6 text-blue-600" />
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-semibold text-gray-900">Email</h3>
                  <p class="text-gray-700 mt-1">{{ villageProfile.email || 'Email belum ditambahkan' }}</p>
                </div>
              </div>

              <div class="flex items-start">
                <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                  <GlobeAltIcon class="w-6 h-6 text-blue-600" />
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-semibold text-gray-900">Website</h3>
                  <p class="text-gray-700 mt-1">
                    <a v-if="villageProfile.website" :href="formatWebsiteUrl(villageProfile.website)" target="_blank" class="text-blue-600 hover:underline">
                      {{ villageProfile.website }}
                    </a>
                    <span v-else>Website belum ditambahkan</span>
                  </p>
                </div>
              </div>

              <div class="flex items-start">
                <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                  <ClockIcon class="w-6 h-6 text-blue-600" />
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-semibold text-gray-900">Jam Operasional</h3>
                  <div class="text-gray-700 mt-1">
                    <p>Senin - Jumat: 08.00 - 16.00</p>
                    <p>Sabtu: 08.00 - 12.00</p>
                    <p>Minggu: Tutup</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Map Placeholder -->
            <div class="mt-8 bg-gray-200 rounded-lg h-64 flex items-center justify-center">
              <p class="text-gray-600">Peta Lokasi Desa</p>
            </div>
          </div>

          <!-- Contact Form -->
          <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>

            <form @submit.prevent="submitForm">
              <div class="space-y-4">
                <div>
                  <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                  <input
                    type="text"
                    id="name"
                    v-model="form.name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    :class="{'border-red-500': errors.name}"
                    placeholder="Masukkan nama lengkap"
                  />
                  <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
                </div>

                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                  <input
                    type="email"
                    id="email"
                    v-model="form.email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    :class="{'border-red-500': errors.email}"
                    placeholder="Masukkan alamat email"
                  />
                  <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
                </div>

                <div>
                  <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                  <input
                    type="tel"
                    id="phone"
                    v-model="form.phone"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    :class="{'border-red-500': errors.phone}"
                    placeholder="Masukkan nomor telepon"
                  />
                  <p v-if="errors.phone" class="mt-1 text-sm text-red-600">{{ errors.phone }}</p>
                </div>

                <div>
                  <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                  <input
                    type="text"
                    id="subject"
                    v-model="form.subject"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    :class="{'border-red-500': errors.subject}"
                    placeholder="Masukkan subjek pesan"
                  />
                  <p v-if="errors.subject" class="mt-1 text-sm text-red-600">{{ errors.subject }}</p>
                </div>

                <div>
                  <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                  <textarea
                    id="message"
                    v-model="form.message"
                    rows="5"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    :class="{'border-red-500': errors.message}"
                    placeholder="Tulis pesan Anda di sini"
                  ></textarea>
                  <p v-if="errors.message" class="mt-1 text-sm text-red-600">{{ errors.message }}</p>
                </div>

                <div class="flex items-center">
                  <input
                    type="checkbox"
                    id="privacy"
                    v-model="form.privacy"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                  />
                  <label for="privacy" class="ml-2 block text-sm text-gray-700">
                    Saya menyetujui <a href="#" class="text-blue-600 hover:underline">kebijakan privasi</a>
                  </label>
                </div>
                <p v-if="errors.privacy" class="mt-1 text-sm text-red-600">{{ errors.privacy }}</p>

                <div>
                  <button
                    type="submit"
                    class="w-full px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    :disabled="processing"
                  >
                    <span v-if="processing">Mengirim...</span>
                    <span v-else>Kirim Pesan</span>
                  </button>
                </div>
              </div>
            </form>

            <!-- Success Message -->
            <div v-if="showSuccess" class="mt-6 p-4 bg-green-50 border border-green-200 rounded-md">
              <div class="flex">
                <CheckCircleIcon class="h-5 w-5 text-green-500" />
                <div class="ml-3">
                  <p class="text-sm font-medium text-green-800">
                    Pesan Anda telah berhasil dikirim! Kami akan segera menghubungi Anda.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-gray-50">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <SectionHeading
          title="Pertanyaan Umum"
          subtitle="Jawaban untuk pertanyaan yang sering diajukan"
        />

        <div class="max-w-3xl mx-auto mt-8">
          <div v-for="(faq, index) in faqs" :key="index" class="mb-4">
            <button
              @click="toggleFaq(index)"
              class="flex justify-between items-center w-full px-6 py-4 text-left bg-white rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none"
            >
              <span class="text-lg font-medium text-gray-900">{{ faq.question }}</span>
              <ChevronDownIcon
                class="w-5 h-5 text-gray-500 transition-transform duration-200"
                :class="{ 'transform rotate-180': openFaq === index }"
              />
            </button>
            <div
              v-show="openFaq === index"
              class="mt-2 px-6 py-4 bg-white rounded-lg shadow-sm"
            >
              <p class="text-gray-700">{{ faq.answer }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </GuestLayout>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import SectionHeading from '@/Components/Guest/SectionHeading.vue'
import {
  MapPinIcon,
  PhoneIcon,
  EnvelopeIcon,
  GlobeAltIcon,
  ClockIcon,
  CheckCircleIcon,
  ChevronDownIcon
} from '@heroicons/vue/24/outline'
// import { route } from 'vue-router'

defineProps({
  villageProfile: {
    type: Object,
    default: () => ({})
  }
})

const form = useForm({
  name: '',
  email: '',
  phone: '',
  subject: '',
  message: '',
  privacy: false
})

const processing = ref(false)
const showSuccess = ref(false)
const openFaq = ref(null)

const faqs = [
  {
    question: 'Bagaimana cara mengajukan surat pengantar dari desa?',
    answer: 'Untuk mengajukan surat pengantar, Anda dapat datang langsung ke kantor desa dengan membawa KTP dan dokumen pendukung lainnya sesuai kebutuhan. Petugas akan membantu Anda untuk memproses surat pengantar yang dibutuhkan.'
  },
  {
    question: 'Berapa lama proses pembuatan surat keterangan dari desa?',
    answer: 'Proses pembuatan surat keterangan dari desa biasanya membutuhkan waktu 1-2 hari kerja, tergantung pada jenis surat dan kelengkapan dokumen yang Anda berikan.'
  },
  {
    question: 'Bagaimana cara melaporkan keluhan atau saran untuk desa?',
    answer: 'Anda dapat melaporkan keluhan atau saran melalui halaman Pengaduan di website ini, atau datang langsung ke kantor desa untuk mengisi formulir pengaduan.'
  },
  {
    question: 'Apakah ada program bantuan sosial dari desa?',
    answer: 'Ya, desa memiliki beberapa program bantuan sosial yang disesuaikan dengan kebutuhan masyarakat. Untuk informasi lebih lanjut, Anda dapat menghubungi kantor desa atau mengecek pengumuman di website ini.'
  },
  {
    question: 'Bagaimana cara mendaftarkan usaha UMKM di desa?',
    answer: 'Untuk mendaftarkan usaha UMKM, Anda dapat datang ke kantor desa dengan membawa dokumen usaha, KTP, dan dokumen pendukung lainnya. Petugas akan membantu Anda untuk proses pendaftaran dan memberikan informasi tentang program-program pendukung UMKM.'
  }
]

const submitForm = () => {
  processing.value = true

  form.post(route('contact.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
      showSuccess.value = true
      setTimeout(() => {
        showSuccess.value = false
      }, 5000)
    },
    onFinish: () => {
      processing.value = false
    }
  })
}

const toggleFaq = (index) => {
  if (openFaq.value === index) {
    openFaq.value = null
  } else {
    openFaq.value = index
  }
}

const formatWebsiteUrl = (url) => {
  if (!url) return ''
  if (url.startsWith('http://') || url.startsWith('https://')) {
    return url
  }
  return `https://${url}`
}
</script>
