<template>
  <div class="font-selector">
    <label class="block text-sm font-medium text-gray-700 mb-2">
      Font Family
    </label>
    <select
      v-model="selectedFont"
      @change="changeFont"
      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
    >
      <option value="'Calibri', 'Arial', sans-serif">Calibri (Default)</option>
      <option value="'Arial', sans-serif">Arial</option>
      <option value="'Poppins', sans-serif">Poppins</option>
      <option value="'Open Sans', sans-serif">Open Sans</option>
      <option value="'Helvetica', 'Arial', sans-serif">Helvetica</option>
      <option value="'Times New Roman', serif">Times New Roman</option>
      <option value="'Tahoma', sans-serif">Tahoma</option>
      <option value="'Verdana', sans-serif">Verdana</option>
    </select>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const props = defineProps({
  modelValue: {
    type: String,
    default: "'Calibri', 'Arial', sans-serif"
  }
})

const emit = defineEmits(['update:modelValue', 'font-changed'])

const selectedFont = ref(props.modelValue)

const changeFont = () => {
  emit('update:modelValue', selectedFont.value)
  emit('font-changed', selectedFont.value)

  // Apply font to the resume container
  const resumeContainer = document.querySelector('.resume-container')
  if (resumeContainer) {
    resumeContainer.style.fontFamily = selectedFont.value
  }
}

onMounted(() => {
  selectedFont.value = props.modelValue
})
</script>

<style scoped>
.font-selector {
  margin-bottom: 1rem;
}
</style>
