<script setup>
import { ref } from "vue";
import BreezeApplicationLogo from "@/Components/ApplicationLogo.vue";
import BreezeDropdown from "@/Components/Dropdown.vue";
import BreezeDropdownLink from "@/Components/DropdownLink.vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import BreezeResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/inertia-vue3";
import Sidebar from "./Sidebar.vue";
import Header from "./Header.vue";
import Footer from "./Footer.vue";

const showingNavigationDropdown = ref(false);
</script>

<template>
  <div>
    <div class="flex min-h-screen bg-gray-100">
      <Sidebar />

      <div class="flex flex-col flex-grow bg-gray-200">
        <Header />

        <!-- Page Content -->
        <div class="mb-auto">
          <slot />
        </div>

        <Footer />
      </div>
    </div>
  </div>
</template>
