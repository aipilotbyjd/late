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

        <Card class="relative w-full max-w-md bg-white/10 backdrop-blur-lg border-white/20 shadow-2xl">
            <CardHeader class="text-center space-y-4">
                <div
                    class="mx-auto w-16 h-16 bg-gradient-to-r from-purple-500 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <Lock class="w-8 h-8 text-white" />
                </div>
                <div class="space-y-2">
                    <CardTitle class="text-3xl font-bold text-white">Two-Factor Authentication</CardTitle>
                    <CardDescription class="text-gray-300">
                        Enter the 6-digit code from your authenticator app
                    </CardDescription>
                </div>
            </CardHeader>

            <CardContent class="space-y-6">
                <form @submit="submit" class="space-y-4">
                    <!-- Code input -->
                    <div class="space-y-2">
                        <Label for="code" class="text-gray-200">Authentication Code</Label>
                        <Input id="code" v-model="form.code" inputmode="numeric" maxlength="6" pattern="\d{6}"
                            placeholder="123456" required
                            class="bg-white/10 border-white/20 text-white placeholder-gray-400 focus:border-purple-400 focus:ring-purple-400/50" />
                        <Alert v-if="form.errors.code" variant="destructive" class="bg-red-500/10 border-red-500/20">
                            <AlertDescription class="text-red-400">
                                {{ form.errors.code }}
                            </AlertDescription>
                        </Alert>
                    </div>

                    <Button type="submit" :disabled="form.processing"
                        class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold transition-all duration-300 transform hover:scale-105 disabled:transform-none shadow-lg">
                        <Loader2 v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                        {{ form.processing ? 'Verifying...' : 'Verify Code' }}
                    </Button>
                </form>

                <!-- Logout Option -->
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
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import { Alert, AlertDescription } from '@/components/ui/alert'
import { Lock, Loader2 } from 'lucide-vue-next'

const form = useForm({
    code: ''
})

const submit = (e) => {
    e.preventDefault()
    form.post('/two-factor-challenge')
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
