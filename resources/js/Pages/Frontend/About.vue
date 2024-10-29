<template>

    <head>
        <title>{{ title }}'s page</title>
    </head>
  <div>
    <h1>This is {{ title }}</h1>
  </div>
</template>

<script setup>

defineProps({
    title: String
});


</script>
