<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
        <Card class="w-full max-w-md shadow-md">
            <CardHeader class="space-y-2 text-center">
                <CardTitle class="text-2xl font-bold">Forgot your password?</CardTitle>
                <CardDescription class="text-sm text-gray-500">
                    Enter your email and we'll send you a password reset link.
                </CardDescription>
            </CardHeader>

            <CardContent>
                <form @submit="submit" class="space-y-4">
                    <div class="space-y-2">
                        <Label for="email">Email address</Label>
                        <Input id="email" type="email" v-model="form.email" placeholder="you@example.com" required />
                        <Alert v-if="form.errors.email" variant="destructive" class="mt-2">
                            <AlertDescription>
                                {{ form.errors.email }}
                            </AlertDescription>
                        </Alert>
                    </div>

                    <Button type="submit" class="w-full" :disabled="form.processing">
                        <Loader2 v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                        <span>{{ form.processing ? "Sending..." : "Send Reset Link" }}</span>
                    </Button>
                </form>
            </CardContent>

            <CardFooter class="justify-center">
                <Link href="/login" class="text-sm text-muted-foreground hover:underline">
                Back to login
                </Link>
            </CardFooter>
        </Card>
    </div>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter
} from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import { Alert, AlertDescription } from '@/components/ui/alert'
import { Loader2 } from 'lucide-vue-next'

const form = useForm({ email: '' })

function submit(e) {
    e.preventDefault()
    form.post('/forgot-password')
}
</script>
