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
                    <Mail class="w-8 h-8 text-white" />
                </div>
                <div class="space-y-2">
                    <CardTitle class="text-3xl font-bold text-white">Verify Email</CardTitle>
                    <CardDescription class="text-gray-300">
                        Please verify your email address to continue
                    </CardDescription>
                </div>
            </CardHeader>

            <CardContent class="space-y-6">
                <div v-if="$page.props.status === 'verification-link-sent'" class="text-green-400 text-sm text-center">
                    A new verification link has been sent to your email.
                </div>

                <form @submit="handleResend" class="space-y-4">
                    <Button type="submit" :disabled="form.processing"
                        class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold transition-all duration-300 transform hover:scale-105 disabled:transform-none shadow-lg">
                        <Loader2 v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                        {{ form.processing ? 'Sending...' : 'Resend Verification Email' }}
                    </Button>
                </form>

                <form @submit="logout" class="text-center">
                    <Button type="submit" variant="link" class="text-purple-300 hover:text-white p-0 h-auto">
                        Log out
                    </Button>
                </form>
            </CardContent>
        </Card>
    </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import { Card, CardHeader, CardContent, CardTitle, CardDescription } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Loader2, Mail } from 'lucide-vue-next'

const page = usePage()

const form = useForm()

const handleResend = (e) => {
    e.preventDefault()
    form.post('/email/verification-notification')
}

const logout = (e) => {
    e.preventDefault()
    form.post('/logout')
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
