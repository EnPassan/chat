<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import BlogPost from '@/components/BlogPost.vue';
import {usePage} from '@inertiajs/vue3'
import { nextTick, onMounted, ref, watch } from 'vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Chat',
        href: '/chat',
    },
];

    /*const page = usePage()
    const blog = page.props.blog
    const user = page.props.user
  
    console.log("test")*/

    const form = useForm({
        message_body: ''
    })

    const submit = () => {
        form.post('/chat')
        form.reset()
    }

    const {chatHistories} = defineProps({
        chatHistories: Array
    })

    const chatWindow = ref()
    watch (
        () => chatHistories,
        () => {
            nextTick(()=> {
                if (chatWindow.value) {
                chatWindow.value.scrollTop = chatWindow.value.scrollHeight
                }   
            })    
        },
        {immediate: true}
    )

    

</script>

<template>
    <Head title="Chat" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="h-full"> 
                <div class="flex-1 min-h-[200px] rounded-xl border border-sidebar-border/100 dark:border-sidebar-border p-4">
                    <div class="max-h-[calc(100vh-320px)] overflow-scroll h-full" ref="chatWindow">
                        <div v-for="chatHistory in chatHistories"
                            :key="chatHistory.id" 
                            :class="[
                                chatHistory.author === 'user' && 'text-right '       
                            ]"
                        >
                            <div :class="[
                                'px-4 py-2 my-2 inline-block',
                                chatHistory.author === 'user' && 'bg-gray-100 text-right rounded-lg',
                                chatHistory.author === 'llm' && 'bg-gray-100 rounded-lg',
                            ]"
                            v-html="chatHistory.message_body">
                            </div>
                        </div>
                    </div>
                    <form @submit.prevent="submit">
                        <div>
                            <label class="font-bold" for="message_body">message</label>
                            <textarea @keydown.enter.prevent="submit" rows="4" class="w-full border rounded-lg" id="message_body" v-model="form.message_body">
                            </textarea>
                            <div v-if="form.errors.message_body" class="text-red-500">{{ form.errors.message_body }}</div>
                        </div>
                        <div>
                            <button type="submit" class="bg-gray-400 text-white px-4 py-2 rounded-lg" :disabled="form.processing">
                                Send
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
