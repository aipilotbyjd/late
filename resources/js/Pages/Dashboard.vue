<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-950">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Dashboard</h2>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">You are currently in the <strong>{{ currentTeam.name }}</strong> team.</p>

                        <!-- Team Switcher -->
                        <div v-if="teams.length > 0" class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Switch Teams</h3>
                            <form @submit.prevent="switchTeam" class="mt-2">
                                <div class="flex items-center space-x-2">
                                    <select v-model="switchTeamForm.team_id" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option v-for="team in teams" :key="team.id" :value="team.id">
                                            {{ team.name }}
                                        </option>
                                    </select>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" :disabled="switchTeamForm.processing">
                                        Switch
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Team Members -->
                        <div v-if="currentTeam.users.length > 0" class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Team Members</h3>
                            <ul class="mt-2 space-y-2">
                                <li v-for="user in currentTeam.users" :key="user.id" class="p-3 bg-gray-50 dark:bg-gray-700 rounded-md flex justify-between items-center">
                                    <div>
                                        <span class="text-gray-800 dark:text-gray-200">{{ user.name }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">({{ user.email }})</span>
                                    </div>
                                    <div class="flex items-center">
                                        <!-- Role Management Dropdown -->
                                        <div v-if="isOwner && $page.props.auth.user.id !== user.id">
                                            <select
                                                :value="user.pivot.role"
                                                @change="updateRole(user, $event.target.value)"
                                                class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-xs"
                                            >
                                                <option value="admin">Admin</option>
                                                <option value="member">Member</option>
                                            </select>
                                        </div>
                                        <div v-else>
                                            <span class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full capitalize">{{ user.pivot.role }}</span>
                                        </div>

                                        <!-- Remove Member Button -->
                                        <div v-if="isOwner && $page.props.auth.user.id !== user.id">
                                            <button @click="removeMember(user)" class="ml-4 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 font-semibold">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Pending Invitations -->
                        <div v-if="currentTeam.invitations.length > 0" class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Pending Invitations</h3>
                            <ul class="mt-2 space-y-2">
                                <li v-for="invitation in currentTeam.invitations" :key="invitation.id" class="p-3 bg-gray-50 dark:bg-gray-700 rounded-md flex justify-between items-center">
                                    <span class="text-gray-800 dark:text-gray-200">{{ invitation.email }}</span>
                                    <button @click="cancelInvitation(invitation)" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 font-semibold">
                                        Cancel
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- Invite Member -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Invite New Member</h3>
                            <form @submit.prevent="sendInvitation" class="mt-2">
                                <div class="flex items-center space-x-2">
                                    <input type="email" v-model="inviteForm.email" placeholder="Email address" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required />
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" :disabled="inviteForm.processing">
                                        Invite
                                    </button>
                                </div>
                                <div v-if="inviteForm.errors.email" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ inviteForm.errors.email }}
                                </div>
                                <div v-if="$page.props.flash.status === 'invitation-sent'" class="mt-2 text-sm text-green-600 dark:text-green-400">
                                    Invitation sent successfully!
                                </div>
                            </form>
                        </div>

                        <div class="mt-6">
                            <a href="/teams/create" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Create New Team
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    teams: Array,
    currentTeam: Object,
    isOwner: Boolean,
});

const switchTeamForm = useForm({
    team_id: props.currentTeam.id,
});

const switchTeam = () => {
    switchTeamForm.put('/current-team', {
        preserveScroll: true,
    });
};

const inviteForm = useForm({
    email: '',
});

const sendInvitation = () => {
    inviteForm.post(route('team-members.store'), {
        preserveScroll: true,
        onSuccess: () => inviteForm.reset('email'),
    });
};

const cancelInvitation = (invitation) => {
    useForm({}).delete(route('team-invitations.destroy', invitation.id), {
        preserveScroll: true,
    });
};

const updateRole = (user, role) => {
    useForm({ role }).put(route('team-members.update', user.id), {
        preserveScroll: true,
    });
};

const removeMember = (user) => {
    if (confirm(`Are you sure you want to remove ${user.name} from the team?`)) {
        useForm({}).delete(route('team-members.destroy', user.id), {
            preserveScroll: true,
        });
    }
};
</script>
