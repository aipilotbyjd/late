<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-zinc-950 px-4">
        <Card class="w-full max-w-md shadow-lg border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">
            <CardHeader class="text-center space-y-4">
                <Lock class="mx-auto w-10 h-10 text-purple-600 dark:text-purple-400" />
                <div class="space-y-1">
                    <CardTitle class="text-2xl font-semibold text-zinc-900 dark:text-white">Welcome Back</CardTitle>
                    <CardDescription class="text-zinc-500 dark:text-zinc-400">Login to your account</CardDescription>
                </div>
            </CardHeader>

            <CardContent class="space-y-6">
                <form @submit="handleSubmit" class="space-y-4">
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
                        <div class="relative">
                            <Input id="password" :type="showPassword ? 'text' : 'password'" v-model="form.password"
                                placeholder="••••••••" required />
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-3 top-2 text-zinc-500 hover:text-zinc-700 dark:hover:text-white">
                                <Eye v-if="!showPassword" class="w-5 h-5" />
                                <EyeOff v-else class="w-5 h-5" />
                            </button>
                        </div>
                        <Alert v-if="form.errors.password" variant="destructive">
                            <AlertDescription>{{ form.errors.password }}</AlertDescription>
                        </Alert>
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="flex justify-between items-center">
                        <label class="flex items-center space-x-2">
                            <Checkbox id="remember" v-model="form.remember" />
                            <span class="text-sm text-zinc-600 dark:text-zinc-300">Remember me</span>
                        </label>
                        <Button variant="link" class="text-sm text-purple-600 dark:text-purple-400 px-0 h-auto"
                            @click="$inertia.visit('/forgot-password')">
                            Forgot password?
                        </Button>
                    </div>

                    <!-- Submit -->
                    <Button type="submit" class="w-full" :disabled="form.processing">
                        <Loader2 v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                        {{ form.processing ? 'Signing in...' : 'Sign In' }}
                    </Button>
                </form>

                <Separator />

                <!-- Social login -->
                <div class="grid grid-cols-2 gap-4">
                    <Button variant="outline">
                        <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M..." /> <!-- Google icon path -->
                        </svg>
                        Google
                    </Button>
                    <Button variant="outline">
                        <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M..." /> <!-- Facebook icon path -->
                        </svg>
                        Facebook
                    </Button>
                </div>
            </CardContent>

            <CardFooter class="justify-center">
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    Don't have an account?
                    <Button variant="link" class="text-purple-600 dark:text-purple-400 px-1 h-auto"
                        @click="$inertia.visit('/register')">
                        Sign up
                    </Button>
                </p>
            </CardFooter>
        </Card>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Card, CardHeader, CardContent, CardFooter, CardTitle, CardDescription } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import { Alert, AlertDescription } from '@/components/ui/alert'
import { Separator } from '@/components/ui/separator'
import { Lock, Eye, EyeOff, Loader2 } from 'lucide-vue-next'

const form = useForm({
    email: '',
    password: '',
    remember: false,
})

const showPassword = ref(false)

const handleSubmit = (e) => {
    e.preventDefault()
    form.post('/login', {
        onFinish: () => form.reset('password'),
    })
}
</script>
