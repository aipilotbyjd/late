<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-zinc-950 px-4">
        <Card class="w-full max-w-md shadow-lg border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">
            <CardHeader class="text-center space-y-4">
                <Lock class="mx-auto w-10 h-10 text-purple-600 dark:text-purple-400" />
                <div class="space-y-1">
                    <CardTitle class="text-2xl font-semibold text-zinc-900 dark:text-white">Create Account</CardTitle>
                    <CardDescription class="text-zinc-500 dark:text-zinc-400">Join us today — it's free.
                    </CardDescription>
                </div>
            </CardHeader>

            <CardContent class="space-y-6">
                <form @submit="handleSubmit" class="space-y-4">
                    <!-- Name -->
                    <div class="space-y-2">
                        <Label for="name">Name</Label>
                        <Input id="name" v-model="form.name" type="text" placeholder="Your full name" required />
                        <Alert v-if="form.errors.name" variant="destructive">
                            <AlertDescription>{{ form.errors.name }}</AlertDescription>
                        </Alert>
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <Label for="email">Email</Label>
                        <Input id="email" v-model="form.email" type="email" placeholder="you@example.com" required />
                        <Alert v-if="form.errors.email" variant="destructive">
                            <AlertDescription>{{ form.errors.email }}</AlertDescription>
                        </Alert>
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <Label for="password">Password</Label>
                        <Input id="password" v-model="form.password" type="password" placeholder="••••••••" required />
                        <Alert v-if="form.errors.password" variant="destructive">
                            <AlertDescription>{{ form.errors.password }}</AlertDescription>
                        </Alert>
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <Label for="password_confirmation">Confirm Password</Label>
                        <Input id="password_confirmation" v-model="form.password_confirmation" type="password"
                            placeholder="••••••••" required />
                    </div>

                    <!-- Submit -->
                    <Button type="submit" class="w-full" :disabled="form.processing">
                        <Loader2 v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                        {{ form.processing ? 'Creating...' : 'Register' }}
                    </Button>
                </form>

                <Separator />

                <div class="text-center text-sm text-zinc-600 dark:text-zinc-400">
                    Already have an account?
                    <Button variant="link" class="text-purple-600 dark:text-purple-400 px-1 h-auto"
                        @click="$inertia.visit('/login')">
                        Sign in
                    </Button>
                </div>
            </CardContent>
        </Card>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Card, CardHeader, CardContent, CardTitle, CardDescription } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import { Alert, AlertDescription } from '@/components/ui/alert'
import { Separator } from '@/components/ui/separator'
import { Lock, Loader2 } from 'lucide-vue-next'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const handleSubmit = (e) => {
    e.preventDefault()
    form.post('/register')
}
</script>
