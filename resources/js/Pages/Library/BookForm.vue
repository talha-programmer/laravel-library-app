<script setup>
import BreezeButton from "@/Components/Button.vue";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeSelect from "@/Components/Select.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
  statusEnums: Array
});

let statuses = props.statusEnums;

let statusConverted = [];
statuses.forEach((element) => {
  statusConverted.push({ text: element, value: element });
});

const form = useForm({
  title: "",
  isbn: "",
  published_at: "",
  status: ""
});

const submit = () => {
  form.post(route("books.store"), {
    // onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <BreezeAuthenticatedLayout>
    <div class="flex flex-col items-center">
      <div
        class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
      >
        <Head title="Add New Book" />
        <h1 class="mb-4 text-xl">Add New Book</h1>
        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
          <div>
            <BreezeLabel for="title" value="Title" />
            <BreezeInput
              id="title"
              type="text"
              class="mt-1 block w-full"
              v-model="form.title"
              required
              autofocus
              autocomplete="title"
            />
          </div>

          <div class="mt-4">
            <BreezeLabel for="isbn" value="ISBN" />
            <BreezeInput
              id="isbn"
              type="number"
              class="mt-1 block w-full"
              v-model="form.isbn"
              required
              autocomplete="isbn"
            />
          </div>

          <div class="mt-4">
            <BreezeLabel for="published_at" value="Published Date" />
            <BreezeInput
              id="published_at"
              type="date"
              class="mt-1 block w-full"
              v-model="form.published_at"
              required
              autocomplete="published_at"
            />
          </div>

          <div class="mt-4">
            <BreezeLabel for="status" value="Status" />

            <BreezeSelect
              id="status"
              class="mt-1 block w-full"
              :options="statusConverted"
              v-model="form.status"
              required
              autocomplete="status"
            />
          </div>

          <div class="flex items-center justify-end mt-4">
            <BreezeButton
              class="ml-4"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Save
            </BreezeButton>
          </div>
        </form>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
