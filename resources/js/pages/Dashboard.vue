<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import BlogPost from '@/components/BlogPost.vue';
import {usePage} from '@inertiajs/vue3'
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

    const page = usePage()
    const blog = page.props.blog
    const user = page.props.user
  
    console.log("test")
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="flex flex-row gap-4 h-full"> 
                <div class="flex-1 min-h-[400px] rounded-xl border border-sidebar-border/100 dark:border-sidebar-border p-4">
                    <BlogPost :blog = "blog" :user = "user" />
                </div>
                <!--<div class="flex flex-col gap-4 w-1/2">
                    <div class="flex-1 aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern />
                    </div>
                    <div class="flex-1 aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern />
                    </div>
                </div>-->
            </div>
        </div>
    </AppLayout>
</template>
