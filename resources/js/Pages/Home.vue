<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-950">
        <Card class="w-full max-w-md p-6 shadow-xl rounded-2xl">
            <CardHeader>
                <h2 class="text-2xl font-bold text-center">Login</h2>
                <p class="text-sm text-muted-foreground text-center">Welcome back! Please enter your credentials.</p>
            </CardHeader>

            <form @submit.prevent="handleLogin">
                <div class="grid gap-4 mt-4">
                    <div class="grid gap-1">
                        <Label for="email">Email</Label>
                        <Input id="email" type="email" v-model="email" placeholder="you@example.com" required />
                    </div>

                    <div class="grid gap-1">
                        <Label for="password">Password</Label>
                        <Input id="password" type="password" v-model="password" placeholder="••••••••" required />
                    </div>

                    <Button type="submit" class="w-full mt-2">Login</Button>
                </div>
            </form>

            <div class="text-center text-sm text-muted-foreground mt-4">
                Don't have an account?
                <a href="/register" class="text-blue-600 hover:underline">Sign up</a>
            </div>
        </Card>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Card, CardHeader } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'

const email = ref('')
const password = ref('')

const handleLogin = () => {
    console.log('Logging in with', email.value, password.value)
    // Call your login API here
}
</script>
