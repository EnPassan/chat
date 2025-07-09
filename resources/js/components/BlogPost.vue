<script setup lang="ts">
    import {usePage} from '@inertiajs/vue3'

    const page = usePage()
    const blog = page.props.blog
    const user = page.props.user
    const t = new Date(blog.created_at)

/* 
1. create a new "chat history" table via a migration
    - author, message_body, timestamps
2. Update UI to be more like a chat
    - show past messages
    - send message box
3. Send message to OpenAI
    - save response in the "chat history" database
4. Update the UI when a response comes back from OpenAI

Bonus:
- Convert to a chess helper.
*/

console.log(blog)
</script>

<template>
    <p class="text-3xl font-seriff text-center mb-5"> {{ blog.title }} </p>
    <p class="text-x font-seriff text-center mb-1">{{ user.name }}</p>
    <p class="text-xs font-seriff text-center mb-5">{{ t.toDateString() }}</p>
    <p class="text-x font-seriff  mb-10" v-html="blog.body"></p>
</template>


