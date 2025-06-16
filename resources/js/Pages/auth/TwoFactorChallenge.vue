<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
        <Card class="w-full max-w-md shadow-md">
            <CardHeader class="space-y-2 text-center">
                <CardTitle class="text-2xl font-bold">Two-Factor Authentication</CardTitle>
                <CardDescription class="text-gray-500 text-sm">
                    Please confirm access to your account by entering the authentication code provided by your
                    authenticator app or backup code.
                </CardDescription>
            </CardHeader>

            <CardContent class="space-y-4">
                <form @submit.prevent="submit">
                    <!-- Code Field -->
                    <div class="space-y-2">
                        <Label for="code">Authenticator Code</Label>
                        <Input id="code" v-model="form.code" type="text" inputmode="numeric"
                            autocomplete="one-time-code" placeholder="123456" class="w-full" autofocus />
                        <Alert v-if="form.errors.code" variant="destructive">
                            <AlertDescription>{{ form.errors.code }}</AlertDescription>
                        </Alert>
                    </div>

                    <!-- OR backup code -->
                    <div class="text-center text-sm text-gray-400 my-2">or</div>

                    <!-- Recovery Code -->
                    <div class="space-y-2">
                        <Label for="recovery_code">Recovery Code</Label>
                        <Input id="recovery_code" v-model="form.recovery_code" type="text" autocomplete="one-time-code"
                            placeholder="your-backup-code" class="w-full" />
                        <Alert v-if="form.errors.recovery_code" variant="destructive">
                            <AlertDescription>{{ form.errors.recovery_code }}</AlertDescription>
                        </Alert>
                    </div>

                    <Button type="submit" class="w-full mt-4" :disabled="form.processing">
                        <Loader2 v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                        {{ form.processing ? 'Verifying...' : 'Verify' }}
                    </Button>
                </form>
            </CardContent>

            <CardFooter class="justify-center">
                <Button variant="ghost" @click="logout" class="text-sm text-gray-500 hover:text-black">
                    Log Out
                </Button>
            </CardFooter>
        </Card>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
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

const form = useForm({
    code: '',
    recovery_code: ''
})

const submit = () => {
    form.post('/two-factor-challenge', {
        onFinish: () => form.reset('code', 'recovery_code')
    })
}

const logout = () => {
    router.post('/logout')
}
</script>
