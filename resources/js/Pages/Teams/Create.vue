<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-950">
        <Card class="w-full max-w-md p-6 shadow-xl rounded-2xl">
            <CardHeader>
                <h2 class="text-2xl font-bold text-center">Create Team</h2>
                <p class="text-sm text-muted-foreground text-center">Give your new team a name.</p>
            </CardHeader>

            <form @submit.prevent="submit">
                <div class="grid gap-4 mt-4">
                    <div class="grid gap-1">
                        <Label for="name">Team Name</Label>
                        <Input id="name" type="text" v-model="form.name" placeholder="Acme Inc." required />
                    </div>

                    <Button type="submit" class="w-full mt-2" :disabled="form.processing">Create</Button>
                </div>
            </form>
        </Card>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { Card, CardHeader } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'

const form = useForm({
    name: '',
})

const submit = () => {
    form.post('/teams', {
        onFinish: () => form.reset('name'),
    })
}
</script>
