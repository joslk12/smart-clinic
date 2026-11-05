<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { apiFetch } from './lib/api'

type Health = { status: string; app: string; time: string }

const health = ref<Health | null>(null)
const error = ref<string | null>(null)

onMounted(async () => {
  try {
    health.value = await apiFetch<Health>('/health')
  } catch (e) {
    error.value = e instanceof Error ? e.message : 'Unknown error'
  }
})
</script>

<template>
  <main class="health">
    <h1>Smart Clinic</h1>
    <p v-if="health">API: {{ health.status }} · {{ health.app }}</p>
    <p v-else-if="error" class="error">API unreachable: {{ error }}</p>
    <p v-else>Connecting to API…</p>
  </main>
</template>

<style scoped>
.health {
  font-family: system-ui, sans-serif;
  padding: 2rem;
}
.error {
  color: #b00020;
}
</style>
