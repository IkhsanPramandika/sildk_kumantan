<template>
  <div class="min-h-screen bg-gray-50">
    <Head :title="showSiteName && title !== 'Dashboard' ? `${title} - Admin Panel` : title" />
    <!-- Mobile sidebar overlay -->
    <div v-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"></div>

    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-56 bg-white shadow-lg transform transition-transform duration-300 ease-in-out" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
      <div class="flex flex-col h-full">
        <!-- Sidebar Header - Compact -->
        <div class="flex items-center justify-between h-14 bg-gradient-to-r from-blue-600 to-blue-700 px-3">
          <div class="flex items-center space-x-2">
            <div class="w-7 h-7 bg-white bg-opacity-20 rounded flex items-center justify-center">
              <ShieldCheckIcon class="w-4 h-4 text-white" />
            </div>
            <h1 class="text-sm font-semibold text-white truncate">Admin Panel</h1>
          </div>
          <button @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded text-white hover:bg-white hover:bg-opacity-20 transition-colors duration-200">
            <XMarkIcon class="w-3.5 h-3.5" />
          </button>
        </div>

        <!-- Navigation - Compact -->
        <nav class="flex-1 overflow-y-auto py-2">
          <div class="px-2 space-y-0.5">
            <!-- Dashboard -->
            <Link :href="route('admin.dashboard')"
              class="group flex items-center px-2 py-2 text-xs font-medium rounded-lg transition-all duration-200"
              :class="$page.component === 'Admin/Dashboard'
                ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-600'
                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
              @click="closeMobileSidebar">
              <div class="flex items-center justify-center w-8 h-8 rounded mr-2 transition-colors duration-200"
                :class="$page.component === 'Admin/Dashboard'
                  ? 'bg-blue-100 text-blue-600'
                  : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200'">
                <ChartPieIcon class="w-4 h-4" />
              </div>
              <span class="truncate">Dashboard</span>
            </Link>

            <!-- Kependudukan -->
            <Link :href="route('admin.residents.index')"
              class="group flex items-center px-2 py-2 text-xs font-medium rounded-lg transition-all duration-200"
              :class="$page.url.includes('/admin/residents')
                ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-600'
                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
              @click="closeMobileSidebar">
              <div class="flex items-center justify-center w-8 h-8 rounded mr-2 transition-colors duration-200"
                :class="$page.url.includes('/admin/residents')
                  ? 'bg-blue-100 text-blue-600'
                  : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200'">
                <UsersIcon class="w-4 h-4" />
              </div>
              <span class="truncate">Kependudukan</span>
            </Link>

            <!-- Potensi Desa -->
            <div class="relative">
              <button
                @click="toggleMenu('potensi')"
                class="group flex items-center justify-between w-full px-2 py-2 text-xs font-medium rounded-lg transition-all duration-200"
                :class="isMenuActive('potensi')
                  ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-600'
                  : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
              >
                <div class="flex items-center min-w-0">
                  <div class="flex items-center justify-center w-8 h-8 rounded mr-2 transition-colors duration-200"
                    :class="isMenuActive('potensi')
                      ? 'bg-blue-100 text-blue-600'
                      : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200'">
                    <SparklesIcon class="w-4 h-4" />
                  </div>
                  <span class="truncate">Potensi Desa</span>
                </div>
                <div class="flex items-center justify-center w-5 h-5 rounded transition-all duration-200"
                  :class="isMenuOpen('potensi') ? 'bg-blue-100 text-blue-600 rotate-180' : 'text-gray-400'">
                  <ChevronDownIcon class="w-3 h-3" />
                </div>
              </button>

              <!-- Submenu - Compact -->
              <div v-show="isMenuOpen('potensi') || isMenuActive('potensi')"
                class="mt-1 ml-2 space-y-0.5 border-l border-gray-100 pl-3 transition-all duration-200">
                <Link
                  :href="route('admin.products.index')"
                  class="group flex items-center px-2 py-2 text-xs rounded transition-all duration-200"
                  :class="$page.url.includes('/admin/products')
                    ? 'bg-blue-50 text-blue-600 border-l-2 border-blue-500 ml-[-1px]'
                    : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'"
                  @click="closeMobileSidebar"
                >
                  <div class="flex items-center justify-center w-7 h-7 rounded mr-2 transition-colors duration-200"
                    :class="$page.url.includes('/admin/products')
                      ? 'bg-blue-100 text-blue-600'
                      : 'bg-gray-50 text-gray-400 group-hover:bg-gray-100'">
                    <ShoppingBagIcon class="w-3.5 h-3.5" />
                  </div>
                  <span class="truncate">UMKM</span>
                </Link>

                <Link
                  :href="route('admin.village-potentials.index', { category: 'sda' })"
                  class="group flex items-center px-2 py-2 text-xs rounded transition-all duration-200"
                  :class="$page.url.includes('village-potentials') && $page.url.includes('category=sda')
                    ? 'bg-blue-50 text-blue-600 border-l-2 border-blue-500 ml-[-1px]'
                    : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'"
                  @click="closeMobileSidebar"
                >
                  <div class="flex items-center justify-center w-7 h-7 rounded mr-2 transition-colors duration-200"
                    :class="$page.url.includes('village-potentials') && $page.url.includes('category=sda')
                      ? 'bg-blue-100 text-blue-600'
                      : 'bg-gray-50 text-gray-400 group-hover:bg-gray-100'">
                    <GlobeAltIcon class="w-3.5 h-3.5" />
                  </div>
                  <span class="truncate">SDA</span>
                </Link>

                <Link
                  :href="route('admin.village-potentials.index', { category: 'infrastruktur' })"
                  class="group flex items-center px-2 py-2 text-xs rounded transition-all duration-200"
                  :class="$page.url.includes('village-potentials') && $page.url.includes('category=infrastruktur')
                    ? 'bg-blue-50 text-blue-600 border-l-2 border-blue-500 ml-[-1px]'
                    : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'"
                  @click="closeMobileSidebar"
                >
                  <div class="flex items-center justify-center w-7 h-7 rounded mr-2 transition-colors duration-200"
                    :class="$page.url.includes('village-potentials') && $page.url.includes('category=infrastruktur')
                      ? 'bg-blue-100 text-blue-600'
                      : 'bg-gray-50 text-gray-400 group-hover:bg-gray-100'">
                    <BuildingOfficeIcon class="w-3.5 h-3.5" />
                  </div>
                  <span class="truncate">Infrastruktur</span>
                </Link>
              </div>
            </div>

            <!-- Kelembagaan Desa -->
            <div class="relative">
              <button
                @click="toggleMenu('kelembagaan')"
                class="group flex items-center justify-between w-full px-2 py-2 text-xs font-medium rounded-lg transition-all duration-200"
                :class="isMenuActive('kelembagaan')
                  ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-600'
                  : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
              >
                <div class="flex items-center min-w-0">
                  <div class="flex items-center justify-center w-8 h-8 rounded mr-2 transition-colors duration-200"
                    :class="isMenuActive('kelembagaan')
                      ? 'bg-blue-100 text-blue-600'
                      : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200'">
                    <BuildingLibraryIcon class="w-4 h-4" />
                  </div>
                  <span class="truncate">Kelembagaan</span>
                </div>
                <div class="flex items-center justify-center w-5 h-5 rounded transition-all duration-200"
                  :class="isMenuOpen('kelembagaan') ? 'bg-blue-100 text-blue-600 rotate-180' : 'text-gray-400'">
                  <ChevronDownIcon class="w-3 h-3" />
                </div>
              </button>

              <!-- Submenu - Compact -->
              <div v-show="isMenuOpen('kelembagaan') || isMenuActive('kelembagaan')"
                class="mt-1 ml-2 space-y-0.5 border-l border-gray-100 pl-3 transition-all duration-200">
                <Link
                  :href="route('admin.village-profile.edit')"
                  class="group flex items-center px-2 py-2 text-xs rounded transition-all duration-200"
                  :class="$page.url.includes('/admin/village-profile')
                    ? 'bg-blue-50 text-blue-600 border-l-2 border-blue-500 ml-[-1px]'
                    : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'"
                  @click="closeMobileSidebar"
                >
                  <div class="flex items-center justify-center w-7 h-7 rounded mr-2 transition-colors duration-200"
                    :class="$page.url.includes('/admin/village-profile')
                      ? 'bg-blue-100 text-blue-600'
                      : 'bg-gray-50 text-gray-400 group-hover:bg-gray-100'">
                    <RectangleGroupIcon class="w-3.5 h-3.5" />
                  </div>
                  <span class="truncate">Struktur</span>
                </Link>

                <Link
                  :href="route('admin.village-history.edit')"
                  class="group flex items-center px-2 py-2 text-xs rounded transition-all duration-200"
                  :class="$page.url.includes('/admin/village-history')
                    ? 'bg-blue-50 text-blue-600 border-l-2 border-blue-500 ml-[-1px]'
                    : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'"
                  @click="closeMobileSidebar"
                >
                  <div class="flex items-center justify-center w-7 h-7 rounded mr-2 transition-colors duration-200"
                    :class="$page.url.includes('/admin/village-history')
                      ? 'bg-blue-100 text-blue-600'
                      : 'bg-gray-50 text-gray-400 group-hover:bg-gray-100'">
                    <ClockIcon class="w-3.5 h-3.5" />
                  </div>
                  <span class="truncate">Sejarah</span>
                </Link>

                <Link
                  :href="route('admin.organizations.edit', 'karang-taruna')"
                  class="group flex items-center px-2 py-2 text-xs rounded transition-all duration-200"
                  :class="$page.url.includes('/organizations/karang-taruna')
                    ? 'bg-blue-50 text-blue-600 border-l-2 border-blue-500 ml-[-1px]'
                    : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'"
                  @click="closeMobileSidebar"
                >
                  <div class="flex items-center justify-center w-7 h-7 rounded mr-2 transition-colors duration-200"
                    :class="$page.url.includes('/organizations/karang-taruna')
                      ? 'bg-blue-100 text-blue-600'
                      : 'bg-gray-50 text-gray-400 group-hover:bg-gray-100'">
                    <UserGroupIcon class="w-3.5 h-3.5" />
                  </div>
                  <span class="truncate">Karang Taruna</span>
                </Link>

                <Link
                  :href="route('admin.organizations.edit', 'bpd')"
                  class="group flex items-center px-2 py-2 text-xs rounded transition-all duration-200"
                  :class="$page.url.includes('/organizations/bpd')
                    ? 'bg-blue-50 text-blue-600 border-l-2 border-blue-500 ml-[-1px]'
                    : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'"
                  @click="closeMobileSidebar"
                >
                  <div class="flex items-center justify-center w-7 h-7 rounded mr-2 transition-colors duration-200"
                    :class="$page.url.includes('/organizations/bpd')
                      ? 'bg-blue-100 text-blue-600'
                      : 'bg-gray-50 text-gray-400 group-hover:bg-gray-100'">
                    <ScaleIcon class="w-3.5 h-3.5" />
                  </div>
                  <span class="truncate">BPD</span>
                </Link>

                <Link
                  :href="route('admin.organizations.edit', 'pkk')"
                  class="group flex items-center px-2 py-2 text-xs rounded transition-all duration-200"
                  :class="$page.url.includes('/organizations/pkk')
                    ? 'bg-blue-50 text-blue-600 border-l-2 border-blue-500 ml-[-1px]'
                    : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'"
                  @click="closeMobileSidebar"
                >
                  <div class="flex items-center justify-center w-7 h-7 rounded mr-2 transition-colors duration-200"
                    :class="$page.url.includes('/organizations/pkk')
                      ? 'bg-blue-100 text-blue-600'
                      : 'bg-gray-50 text-gray-400 group-hover:bg-gray-100'">
                    <HeartIcon class="w-3.5 h-3.5" />
                  </div>
                  <span class="truncate">PKK</span>
                </Link>
              </div>
            </div>

            <!-- Informasi Publik -->
            <div class="relative">
              <button
                @click="toggleMenu('informasi')"
                class="group flex items-center justify-between w-full px-2 py-2 text-xs font-medium rounded-lg transition-all duration-200"
                :class="isMenuActive('informasi')
                  ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-600'
                  : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
              >
                <div class="flex items-center min-w-0">
                  <div class="flex items-center justify-center w-8 h-8 rounded mr-2 transition-colors duration-200"
                    :class="isMenuActive('informasi')
                      ? 'bg-blue-100 text-blue-600'
                      : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200'">
                    <SpeakerWaveIcon class="w-4 h-4" />
                  </div>
                  <span class="truncate">Informasi</span>
                </div>
                <div class="flex items-center justify-center w-5 h-5 rounded transition-all duration-200"
                  :class="isMenuOpen('informasi') ? 'bg-blue-100 text-blue-600 rotate-180' : 'text-gray-400'">
                  <ChevronDownIcon class="w-3 h-3" />
                </div>
              </button>

              <!-- Submenu - Compact -->
              <div v-show="isMenuOpen('informasi') || isMenuActive('informasi')"
                class="mt-1 ml-2 space-y-0.5 border-l border-gray-100 pl-3 transition-all duration-200">
                <Link
                  :href="route('admin.news.index')"
                  class="group flex items-center px-2 py-2 text-xs rounded transition-all duration-200"
                  :class="$page.url.includes('/admin/news')
                    ? 'bg-blue-50 text-blue-600 border-l-2 border-blue-500 ml-[-1px]'
                    : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'"
                  @click="closeMobileSidebar"
                >
                  <div class="flex items-center justify-center w-7 h-7 rounded mr-2 transition-colors duration-200"
                    :class="$page.url.includes('/admin/news')
                      ? 'bg-blue-100 text-blue-600'
                      : 'bg-gray-50 text-gray-400 group-hover:bg-gray-100'">
                    <NewspaperIcon class="w-3.5 h-3.5" />
                  </div>
                  <span class="truncate">Berita</span>
                </Link>

                <Link
                  :href="route('admin.events.index')"
                  class="group flex items-center px-2 py-2 text-xs rounded transition-all duration-200"
                  :class="$page.url.includes('/admin/events')
                    ? 'bg-blue-50 text-blue-600 border-l-2 border-blue-500 ml-[-1px]'
                    : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'"
                  @click="closeMobileSidebar"
                >
                  <div class="flex items-center justify-center w-7 h-7 rounded mr-2 transition-colors duration-200"
                    :class="$page.url.includes('/admin/events')
                      ? 'bg-blue-100 text-blue-600'
                      : 'bg-gray-50 text-gray-400 group-hover:bg-gray-100'">
                    <CalendarDaysIcon class="w-3.5 h-3.5" />
                  </div>
                  <span class="truncate">Kegiatan</span>
                </Link>
              </div>
            </div>

            <!-- Gallery Desa -->
            <Link :href="route('admin.galleries.index')"
              class="group flex items-center px-2 py-2 text-xs font-medium rounded-lg transition-all duration-200"
              :class="$page.url.includes('/admin/galleries')
                ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-600'
                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
              @click="closeMobileSidebar">
              <div class="flex items-center justify-center w-8 h-8 rounded mr-2 transition-colors duration-200"
                :class="$page.url.includes('/admin/galleries')
                  ? 'bg-blue-100 text-blue-600'
                  : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200'">
                <PhotoIcon class="w-4 h-4" />
              </div>
              <span class="truncate">Gallery</span>
            </Link>

            <!-- Pengaduan -->
            <Link :href="route('admin.complaints.index')"
              class="group flex items-center px-2 py-2 text-xs font-medium rounded-lg transition-all duration-200"
              :class="$page.url.includes('/admin/complaints')
                ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-600'
                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
              @click="closeMobileSidebar">
              <div class="flex items-center justify-center w-8 h-8 rounded mr-2 transition-colors duration-200"
                :class="$page.url.includes('/admin/complaints')
                  ? 'bg-blue-100 text-blue-600'
                  : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200'">
                <ChatBubbleLeftRightIcon class="w-4 h-4" />
              </div>
              <span class="truncate">Pengaduan</span>
            </Link>
          </div>
        </nav>

        <!-- User Profile Section - Compact -->
        <div class="border-t border-gray-200 p-3">
          <div class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
              <span class="text-white text-xs font-semibold">{{ $page.props.auth.user.name.charAt(0) }}</span>
            </div>
            <div class="min-w-0 flex-1">
              <p class="text-xs font-medium text-gray-900 truncate">{{ $page.props.auth.user.name }}</p>
              <p class="text-[11px] text-gray-500 truncate">Admin</p>
            </div>
            <Link :href="route('logout')" method="post"
              class="p-1.5 rounded hover:bg-red-50 hover:text-red-600 transition-colors duration-200 group"
              title="Logout"
              @click="closeMobileSidebar">
              <ArrowRightOnRectangleIcon class="w-3.5 h-3.5 text-gray-400 group-hover:text-red-500" />
            </Link>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="lg:ml-56 flex flex-col min-h-screen">
      <!-- Top Navigation - Compact -->
      <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30">
        <div class="flex items-center justify-between px-4 py-2.5">
          <div class="flex items-center min-w-0">
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-1.5 rounded text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-200 mr-2">
              <Bars3Icon class="w-4 h-4" />
            </button>
            <div class="flex items-center space-x-2">
              <div class="w-7 h-7 bg-gradient-to-br from-blue-500 to-blue-600 rounded flex items-center justify-center lg:hidden">
                <ShieldCheckIcon class="w-3.5 h-3.5 text-white" />
              </div>
              <h2 class="text-sm font-semibold text-gray-800 truncate">{{ title }}</h2>
            </div>
          </div>

          <!-- Desktop Profile Dropdown - Compact -->
          <div class="hidden lg:flex items-center space-x-3">
            <div class="relative">
              <button @click="profileDropdownOpen = !profileDropdownOpen" class="flex items-center space-x-2 px-2 py-1.5 rounded text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                <div class="w-7 h-7 bg-gradient-to-br from-blue-500 to-blue-600 rounded flex items-center justify-center">
                  <span class="text-white text-xs font-semibold">{{ $page.props.auth.user.name.charAt(0) }}</span>
                </div>
                <div class="hidden xl:block text-left">
                  <p class="text-xs font-medium text-gray-900 truncate max-w-[100px]">{{ $page.props.auth.user.name }}</p>
                  <p class="text-[11px] text-gray-500">Admin</p>
                </div>
                <ChevronDownIcon class="w-2.5 h-2.5 text-gray-400" />
              </button>

              <div v-show="profileDropdownOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-md py-1.5 z-50 border border-gray-100 text-sm">
                <div class="px-3 py-2 border-b border-gray-100">
                  <p class="text-xs font-medium text-gray-900 truncate">{{ $page.props.auth.user.name }}</p>
                  <p class="text-[11px] text-gray-500">Admin</p>
                </div>
                <Link :href="route('admin.profile.edit')" class="flex items-center px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                  <UserIcon class="w-3.5 h-3.5 mr-2 text-gray-400" />
                  Profil
                </Link>
                <Link :href="route('logout')" method="post" class="flex items-center px-3 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors duration-200">
                  <ArrowRightOnRectangleIcon class="w-3.5 h-3.5 mr-2 text-red-500" />
                  Keluar
                </Link>
              </div>
            </div>
          </div>

          <!-- Mobile User Info - Compact -->
          <div class="lg:hidden flex items-center space-x-1">
            <div class="w-7 h-7 bg-gradient-to-br from-blue-500 to-blue-600 rounded flex items-center justify-center">
              <span class="text-white text-xs font-semibold">{{ $page.props.auth.user.name.charAt(0) }}</span>
            </div>
          </div>
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 p-4 overflow-x-auto">
        <div class="max-w-full">
          <slot />
        </div>
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import {
  ChartPieIcon,
  UsersIcon,
  SparklesIcon,
  BuildingLibraryIcon,
  SpeakerWaveIcon,
  PhotoIcon,
  ChatBubbleLeftRightIcon,
  ShoppingBagIcon,
  GlobeAltIcon,
  BuildingOfficeIcon,
  RectangleGroupIcon,
  ClockIcon,
  UserGroupIcon,
  ScaleIcon,
  HeartIcon,
  NewspaperIcon,
  CalendarDaysIcon,
  ChevronDownIcon,
  Bars3Icon,
  XMarkIcon,
  ShieldCheckIcon,
  UserIcon,
  ArrowRightOnRectangleIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
  title: {
    type: String,
    default: 'Admin Panel'
  },
  showSiteName: {
    type: Boolean,
    default: true
  }
});

const page = usePage();
const sidebarOpen = ref(false);
const profileDropdownOpen = ref(false);
const openMenus = ref([]);

const isMenuOpen = (menu) => {
  return openMenus.value.includes(menu);
};

const isMenuActive = (menu) => {
  if (menu === 'potensi') {
    return page.url.includes('/admin/products') || page.url.includes('village-potentials');
  }
  if (menu === 'kelembagaan') {
    return page.url.includes('/admin/village-profile') ||
      page.url.includes('/admin/village-history') ||
      page.url.includes('/organizations/');
  }
  if (menu === 'informasi') {
    return page.url.includes('/admin/news') || page.url.includes('/admin/events');
  }
  return false;
};

const toggleMenu = (menu) => {
  const index = openMenus.value.indexOf(menu);
  if (index === -1) {
    openMenus.value.push(menu);
  } else {
    openMenus.value.splice(index, 1);
  }
};

const closeMobileSidebar = () => {
  if (window.innerWidth < 1024) {
    sidebarOpen.value = false;
  }
};

const handleClickOutside = (event) => {
  if (!event.target.closest('.relative')) {
    profileDropdownOpen.value = false;
  }
};

const handleResize = () => {
  if (window.innerWidth >= 1024) {
    sidebarOpen.value = false;
  }
};

// Auto-open menu based on current route
const autoOpenMenus = () => {
  if (page.url.includes('/admin/products') || page.url.includes('village-potentials')) {
    if (!isMenuOpen('potensi')) {
      openMenus.value.push('potensi');
    }
  }

  if (page.url.includes('/admin/village-profile') || page.url.includes('/admin/village-history') || page.url.includes('/organizations/')) {
    if (!isMenuOpen('kelembagaan')) {
      openMenus.value.push('kelembagaan');
    }
  }

  if (page.url.includes('/admin/news') || page.url.includes('/admin/events')) {
    if (!isMenuOpen('informasi')) {
      openMenus.value.push('informasi');
    }
  }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
  window.addEventListener('resize', handleResize);
  autoOpenMenus();
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
  window.removeEventListener('resize', handleResize);
});
</script>
