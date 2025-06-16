<template>
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 p-4">
        <!-- Animated Background -->
        <div class="absolute inset-0 overflow-hidden">
            <div
                class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob" />
            <div
                class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000" />
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000" />
        </div>

        <!-- Card -->
        <Card class="relative w-full max-w-md bg-white/10 backdrop-blur-lg border-white/20 shadow-2xl">
            <CardHeader class="text-center space-y-4">
                <div
                    class="mx-auto w-16 h-16 bg-gradient-to-r from-purple-500 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <Lock class="w-8 h-8 text-white" />
                </div>
                <div class="space-y-2">
                    <CardTitle class="text-3xl font-bold text-white">Reset Password</CardTitle>
                    <CardDescription class="text-gray-300">
                        Enter your new password below
                    </CardDescription>
                </div>
            </CardHeader>

            <CardContent class="space-y-6">
                <form @submit="handleSubmit" class="space-y-4">
                    <!-- Email -->
                    <div class="space-y-2">
                        <Label for="email" class="text-gray-200">Email</Label>
                        <Input id="email" v-model="form.email" type="email" required
                            class="bg-white/10 border-white/20 text-white placeholder-gray-400 focus:border-purple-400 focus:ring-purple-400/50"
                            placeholder="Enter your email" />
                        <Alert v-if="form.errors.email" variant="destructive" class="bg-red-500/10 border-red-500/20">
                            <AlertDescription class="text-red-400">{{ form.errors.email }}</AlertDescription>
                        </Alert>
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <Label for="password" class="text-gray-200">New Password</Label>
                        <Input id="password" v-model="form.password" type="password" required
                            class="bg-white/10 border-white/20 text-white placeholder-gray-400 focus:border-purple-400 focus:ring-purple-400/50"
                            placeholder="Enter new password" />
                        <Alert v-if="form.errors.password" variant="destructive"
                            class="bg-red-500/10 border-red-500/20">
                            <AlertDescription class="text-red-400">{{ form.errors.password }}</AlertDescription>
                        </Alert>
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <Label for="password_confirmation" class="text-gray-200">Confirm Password</Label>
                        <Input id="password_confirmation" v-model="form.password_confirmation" type="password" required
                            class="bg-white/10 border-white/20 text-white placeholder-gray-400 focus:border-purple-400 focus:ring-purple-400/50"
                            placeholder="Confirm new password" />
                    </div>

                    <!-- Submit -->
                    <Button type="submit" :disabled="form.processing"
                        class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold transition-all duration-300 transform hover:scale-105 disabled:transform-none shadow-lg">
                        <Loader2 v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                        {{ form.processing ? 'Resetting...' : 'Reset Password' }}
                    </Button>
                </form>
            </CardContent>
        </Card>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { Card, CardHeader, CardContent, CardTitle, CardDescription } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import { Alert, AlertDescription } from '@/components/ui/alert'
import { Lock, Loader2 } from 'lucide-vue-next'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

const form = useForm({
    token: page.props.token,
    email: page.props.email ?? '',
    password: '',
    password_confirmation: ''
})

const handleSubmit = (e) => {
    e.preventDefault()
    form.post('/reset-password', {
        onSuccess: () => form.reset('password', 'password_confirmation')
    })
}
</script>

<style scoped>
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }

    33% {
        transform: translate(30px, -50px) scale(1.1);
    }

    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }

    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
