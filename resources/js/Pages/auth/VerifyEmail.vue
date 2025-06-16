<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
        <Card class="w-full max-w-md shadow-md text-center">
            <CardHeader class="space-y-2">
                <CardTitle class="text-2xl font-bold">Verify Your Email</CardTitle>
                <CardDescription class="text-gray-500 text-sm">
                    Thanks for signing up! Before getting started, please verify your email address by clicking the link
                    we just emailed to you. If you didn't receive the email, we will gladly send you another.
                </CardDescription>
            </CardHeader>

            <CardContent class="space-y-4">
                <!-- Status Message -->
                <div v-if="status === 'verification-link-sent'" class="text-green-600 text-sm">
                    A new verification link has been sent to your email address.
                </div>

                <!-- Resend Button -->
                <form @submit.prevent="submit">
                    <Button :disabled="form.processing" type="submit" class="w-full">
                        <Loader2 v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                        <span>{{ form.processing ? 'Sending...' : 'Resend Verification Email' }}</span>
                    </Button>
                </form>
            </CardContent>

            <CardFooter class="flex justify-between items-center">
                <Button variant="ghost" @click="logout" class="text-sm text-gray-500 hover:text-black">
                    Log Out
                </Button>
            </CardFooter>
        </Card>
    </div>
</template>

<script setup>
import { useForm, router, usePage } from '@inertiajs/vue3'
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter
} from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Loader2 } from 'lucide-vue-next'

// Props
const { status } = usePage().props

// Form
const form = useForm({})

// Submit resend email
const submit = () => {
    form.post('/email/verification-notification', {
        preserveScroll: true
    })
}

// Logout
const logout = () => {
    router.post('/logout')
}
</script>
