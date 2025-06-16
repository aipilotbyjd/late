<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
        <Card class="w-full max-w-md shadow-md">
            <CardHeader class="text-center space-y-2">
                <CardTitle class="text-2xl font-bold">Reset Password</CardTitle>
                <CardDescription class="text-sm text-gray-500">
                    Enter your new password to reset your account.
                </CardDescription>
            </CardHeader>

            <CardContent>
                <form @submit="submit" class="space-y-4">
                    <!-- Email -->
                    <div class="space-y-2">
                        <Label for="email">Email Address</Label>
                        <Input id="email" type="email" v-model="form.email" autocomplete="username" required />
                        <Alert v-if="form.errors.email" variant="destructive" class="mt-2">
                            <AlertDescription>
                                {{ form.errors.email }}
                            </AlertDescription>
                        </Alert>
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <Label for="password">New Password</Label>
                        <Input id="password" type="password" v-model="form.password" autocomplete="new-password"
                            required />
                        <Alert v-if="form.errors.password" variant="destructive" class="mt-2">
                            <AlertDescription>
                                {{ form.errors.password }}
                            </AlertDescription>
                        </Alert>
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <Label for="password_confirmation">Confirm Password</Label>
                        <Input id="password_confirmation" type="password" v-model="form.password_confirmation"
                            autocomplete="new-password" required />
                        <Alert v-if="form.errors.password_confirmation" variant="destructive" class="mt-2">
                            <AlertDescription>
                                {{ form.errors.password_confirmation }}
                            </AlertDescription>
                        </Alert>
                    </div>

                    <Button type="submit" class="w-full" :disabled="form.processing">
                        <Loader2 v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                        <span>{{ form.processing ? "Resetting..." : "Reset Password" }}</span>
                    </Button>
                </form>
            </CardContent>
        </Card>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent
} from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import { Alert, AlertDescription } from '@/components/ui/alert'
import { Loader2 } from 'lucide-vue-next'
import { usePage } from '@inertiajs/vue3'

// Get reset token from the page props
const { token } = usePage().props

const form = useForm({
    token: token || '',
    email: '',
    password: '',
    password_confirmation: ''
})

function submit(e) {
    e.preventDefault()
    form.post('/reset-password', {
        onFinish: () => form.reset('password', 'password_confirmation')
    })
}
</script>
