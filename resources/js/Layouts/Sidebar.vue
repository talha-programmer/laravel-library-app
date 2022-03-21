<script setup>
import { Link } from "@inertiajs/inertia-vue3";
</script>
<template>
  <aside class="hidden w-64 bg-gray-800 sm:block">
    <div
      class="py-3 text-2xl uppercase text-center tracking-widest bg-gray-900 border-b-2 border-gray-800 mb-8"
    >
      <Link :href="route('dashboard')" class="text-white">Library App</Link>
    </div>

    <nav class="text-sm text-gray-300">
      <ul class="flex flex-col">
        <li class="px-4 cursor-pointer hover:bg-gray-700">
          <Link :href="route('books')" class="text-white py-1 flex items-center">All Books</Link>
        </li>
        <li class="px-4 cursor-pointer hover:bg-gray-700">
          <Link :href="route('books.form')" class="text-white py-1 flex items-center">New Book</Link>
        </li>
      </ul>
    </nav>
  </aside>
</template>
