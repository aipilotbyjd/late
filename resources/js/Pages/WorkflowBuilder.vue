<template>
    <div class="flex flex-col h-screen p-4 space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold tracking-tight">Workflow Builder</h2>
            <div class="flex items-center space-x-2">
                <Button @click="fitView" variant="secondary">Fit View</Button>
                <Button @click="addNode">+ Add Node</Button>
            </div>
        </div>

        <div ref="canvas" class="flex-1 bg-muted rounded-xl shadow-md relative overflow-hidden">
            <vue-flow v-model:nodes="nodes" v-model:edges="edges" :default-viewport="viewport" :fit-view-on-init="true"
                :auto-connect="true" :min-zoom="0.5" :max-zoom="2" class="w-full h-full">
                <template #node-custom="{ data, id }">
                    <Card class="w-60 rounded-2xl shadow-lg border border-border">
                        <CardContent class="p-4 space-y-2">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold truncate">{{ data.label }}</h3>
                                <Button variant="ghost" size="icon" @click="removeNode(id)">
                                    <XIcon class="w-4 h-4" />
                                </Button>
                            </div>
                            <Input v-model="data.label" placeholder="Edit node label" class="w-full" />
                            <div class="text-xs text-muted-foreground">ID: {{ id }}</div>
                        </CardContent>
                    </Card>
                </template>
            </vue-flow>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Card, CardContent } from '@/components/ui/card'
import { XIcon } from 'lucide-vue-next'
import { VueFlow, useVueFlow } from '@vue-flow/core'
import '@vue-flow/core/dist/style.css'

const { fitView } = useVueFlow()

const nodes = ref([
    {
        id: '1',
        type: 'custom',
        position: { x: 100, y: 100 },
        data: { label: 'Start Node' },
    },
])

const edges = ref([])

const viewport = { zoom: 1, x: 0, y: 0 }

function addNode() {
    const id = String(Date.now())
    nodes.value.push({
        id,
        type: 'custom',
        position: { x: 150 + Math.random() * 200, y: 150 + Math.random() * 200 },
        data: { label: 'New Node' },
    })
}

function removeNode(id) {
    nodes.value = nodes.value.filter(n => n.id !== id)
    edges.value = edges.value.filter(e => e.source !== id && e.target !== id)
}
</script>

<style scoped>
.vue-flow__node-custom {
    background: transparent;
    border: none;
}
</style>
