<template>
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 p-4">
        <!-- Animated background -->
        <div class="absolute inset-0 overflow-hidden">
            <div
                class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob">
            </div>
            <div
                class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000">
            </div>
        </div>

        <!-- Register Card -->
        <Card class="relative w-full max-w-md bg-white/10 backdrop-blur-lg border-white/20 shadow-2xl">
            <CardHeader class="text-center space-y-4">
                <div
                    class="mx-auto w-16 h-16 bg-gradient-to-r from-purple-500 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <UserPlus class="w-8 h-8 text-white" />
                </div>
                <div class="space-y-2">
                    <CardTitle class="text-3xl font-bold text-white">Create Account</CardTitle>
                    <CardDescription class="text-gray-300">
                        Join us and start your journey today
                    </CardDescription>
                </div>
            </CardHeader>

            <CardContent class="space-y-6">
                <form @submit="handleSubmit" class="space-y-4">
                    <div class="space-y-4">
                        <!-- Name Field -->
                        <div class="space-y-2">
                            <Label for="name" class="text-gray-200">Full Name</Label>
                            <div class="relative">
                                <Input id="name" v-model="form.name" type="text" placeholder="Enter your full name"
                                    required
                                    class="bg-white/10 border-white/20 text-white placeholder-gray-400 focus:border-purple-400 focus:ring-purple-400/50 pr-10" />
                                <User class="absolute right-3 top-3 h-4 w-4 text-gray-400" />
                            </div>
                            <Alert v-if="form.errors.name" variant="destructive"
                                class="bg-red-500/10 border-red-500/20">
                                <AlertDescription class="text-red-400">
                                    {{ form.errors.name }}
                                </AlertDescription>
                            </Alert>
                        </div>

                        <!-- Email Field -->
                        <div class="space-y-2">
                            <Label for="email" class="text-gray-200">Email Address</Label>
                            <div class="relative">
                                <Input id="email" v-model="form.email" type="email" placeholder="Enter your email"
                                    required
                                    class="bg-white/10 border-white/20 text-white placeholder-gray-400 focus:border-purple-400 focus:ring-purple-400/50 pr-10" />
                                <Mail class="absolute right-3 top-3 h-4 w-4 text-gray-400" />
                            </div>
                            <Alert v-if="form.errors.email" variant="destructive"
                                class="bg-red-500/10 border-red-500/20">
                                <AlertDescription class="text-red-400">
                                    {{ form.errors.email }}
                                </AlertDescription>
                            </Alert>
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-2">
                            <Label for="password" class="text-gray-200">Password</Label>
                            <div class="relative">
                                <Input id="password" v-model="form.password" :type="showPassword ? 'text' : 'password'"
                                    placeholder="Create a strong password" required
                                    class="bg-white/10 border-white/20 text-white placeholder-gray-400 focus:border-purple-400 focus:ring-purple-400/50 pr-10" />
                                <Button type="button" variant="ghost" size="sm" @click="showPassword = !showPassword"
                                    class="absolute right-0 top-0 h-full px-3 py-2 hover:bg-transparent text-gray-400 hover:text-white">
                                    <Eye v-if="showPassword" class="h-4 w-4" />
                                    <EyeOff v-else class="h-4 w-4" />
                                </Button>
                            </div>

                            <!-- Password Strength Indicator -->
                            <div class="space-y-2">
                                <div class="flex space-x-1">
                                    <div v-for="i in 4" :key="i" :class="[
                                        'h-1 w-full rounded-full transition-all duration-300',
                                        passwordStrength >= i ? getStrengthColor(passwordStrength) : 'bg-gray-600'
                                    ]"></div>
                                </div>
                                <p class="text-xs text-gray-400">
                                    {{ passwordStrengthText }}
                                </p>
                            </div>

                            <Alert v-if="form.errors.password" variant="destructive"
                                class="bg-red-500/10 border-red-500/20">
                                <AlertDescription class="text-red-400">
                                    {{ form.errors.password }}
                                </AlertDescription>
                            </Alert>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="space-y-2">
                            <Label for="password_confirmation" class="text-gray-200">Confirm Password</Label>
                            <div class="relative">
                                <Input id="password_confirmation" v-model="form.password_confirmation"
                                    :type="showConfirmPassword ? 'text' : 'password'"
                                    placeholder="Confirm your password" required
                                    class="bg-white/10 border-white/20 text-white placeholder-gray-400 focus:border-purple-400 focus:ring-purple-400/50 pr-10" />
                                <Button type="button" variant="ghost" size="sm"
                                    @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute right-0 top-0 h-full px-3 py-2 hover:bg-transparent text-gray-400 hover:text-white">
                                    <Eye v-if="showConfirmPassword" class="h-4 w-4" />
                                    <EyeOff v-else class="h-4 w-4" />
                                </Button>
                            </div>

                            <Alert v-if="form.errors.password_confirmation" variant="destructive"
                                class="bg-red-500/10 border-red-500/20">
                                <AlertDescription class="text-red-400">
                                    {{ form.errors.password_confirmation }}
                                </AlertDescription>
                            </Alert>

                            <Alert v-if="passwordMismatch" variant="destructive"
                                class="bg-red-500/10 border-red-500/20">
                                <AlertDescription class="text-red-400">
                                    Passwords do not match
                                </AlertDescription>
                            </Alert>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-start space-x-2">
                        <Checkbox id="terms" v-model="form.terms" required
                            class="border-white/20 data-[state=checked]:bg-purple-600 data-[state=checked]:border-purple-600 mt-1" />
                        <Label for="terms" class="text-sm text-gray-300 leading-relaxed">
                            I agree to the
                            <Button variant="link" class="text-purple-400 hover:text-purple-300 p-0 h-auto">
                                Terms of Service
                            </Button>
                            and
                            <Button variant="link" class="text-purple-400 hover:text-purple-300 p-0 h-auto">
                                Privacy Policy
                            </Button>
                        </Label>
                    </div>
                    <Alert v-if="form.errors.terms" variant="destructive" class="bg-red-500/10 border-red-500/20">
                        <AlertDescription class="text-red-400">
                            {{ form.errors.terms }}
                        </AlertDescription>
                    </Alert>

                    <!-- Submit Button -->
                    <Button type="submit" :disabled="form.processing || !isFormValid"
                        class="w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold transition-all duration-300 transform hover:scale-105 disabled:transform-none shadow-lg">
                        <Loader2 v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                        {{ form.processing ? 'Creating Account...' : 'Create Account' }}
                    </Button>
                </form>

                <!-- Divider -->
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <Separator class="w-full bg-white/20" />
                    </div>
                    <div class="relative flex justify-center text-xs uppercase">
                        <span class="bg-transparent px-2 text-gray-400">Or continue with</span>
                    </div>
                </div>

                <!-- Social Login -->
                <div class="grid grid-cols-2 gap-4">
                    <Button variant="outline"
                        class="bg-white/5 border-white/20 text-gray-300 hover:bg-white/10 hover:text-white transition-all duration-300 hover:scale-105">
                        <svg class="mr-2 h-4 w-4" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="currentColor"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="currentColor"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="currentColor"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        Google
                    </Button>
                    <Button variant="outline"
                        class="bg-white/5 border-white/20 text-gray-300 hover:bg-white/10 hover:text-white transition-all duration-300 hover:scale-105">
                        <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                        Facebook
                    </Button>
                </div>
            </CardContent>

            <CardFooter class="justify-center">
                <p class="text-gray-300 text-sm">
                    Already have an account?
                    <Button variant="link" class="text-purple-400 hover:text-purple-300 p-0 h-auto ml-1">
                        Sign in here
                    </Button>
                </p>
            </CardFooter>
        </Card>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import { Alert, AlertDescription } from '@/components/ui/alert'
import { Separator } from '@/components/ui/separator'
import { UserPlus, User, Mail, Eye, EyeOff, Loader2 } from 'lucide-vue-next'

// Form state
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false
})

// UI state
const showPassword = ref(false)
const showConfirmPassword = ref(false)

// Password strength calculation
const passwordStrength = computed(() => {
    const password = form.password
    if (!password) return 0

    let strength = 0
    if (password.length >= 8) strength++
    if (/[a-z]/.test(password)) strength++
    if (/[A-Z]/.test(password)) strength++
    if (/[0-9]/.test(password)) strength++
    if (/[^A-Za-z0-9]/.test(password)) strength++

    return Math.min(strength, 4)
})

const passwordStrengthText = computed(() => {
    switch (passwordStrength.value) {
        case 0: return 'Enter a password'
        case 1: return 'Weak password'
        case 2: return 'Fair password'
        case 3: return 'Good password'
        case 4: return 'Strong password'
        default: return ''
    }
})

const getStrengthColor = (strength) => {
    switch (strength) {
        case 1: return 'bg-red-500'
        case 2: return 'bg-yellow-500'
        case 3: return 'bg-blue-500'
        case 4: return 'bg-green-500'
        default: return 'bg-gray-600'
    }
}

// Form validation
const passwordMismatch = computed(() => {
    return form.password && form.password_confirmation && form.password !== form.password_confirmation
})

const isFormValid = computed(() => {
    return form.name &&
        form.email &&
        form.password &&
        form.password_confirmation &&
        form.password === form.password_confirmation &&
        form.terms &&
        passwordStrength.value >= 2
})

// Form submission
const handleSubmit = (e) => {
    e.preventDefault()
    form.post('/register', {
        onFinish: () => {
            form.reset('password', 'password_confirmation')
        }
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
