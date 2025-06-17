<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-gray-100">Join Team</h2>
            <p class="mt-2 text-center text-gray-600 dark:text-gray-400">
                You have been invited to join the <strong>{{ invitation.team.name }}</strong> team!
            </p>

            <div v-if="$page.props.auth.user">
                <div class="mt-6 text-center">
                    <p class="text-gray-600 dark:text-gray-400">You are currently logged in as {{ $page.props.auth.user.email }}.</p>
                    <form @submit.prevent="acceptInvitation" class="mt-4">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" :disabled="form.processing">
                            Accept Invitation
                        </button>
                    </form>
                </div>
            </div>

            <div v-else>
                <p class="mt-6 text-center text-gray-600 dark:text-gray-400">
                    To accept this invitation, please create an account.
                </p>
                <form @submit.prevent="registerAndAccept" class="mt-4 space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input id="name" type="text" v-model="form.name" required autofocus autocomplete="name" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
                        <div v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input id="email" type="email" v-model="form.email" required autocomplete="username" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
                        <div v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                        <input id="password" type="password" v-model="form.password" required autocomplete="new-password" class="mt-1 block w-full border-gray-300 dark:border-gamma-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
                        <div v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                        <input id="password_confirmation" type="password" v-model="form.password_confirmation" required autocomplete="new-password" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" :disabled="form.processing">
                            Register and Join Team
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    invitation: Object,
});

const page = usePage();

const form = useForm({
    name: '',
    email: props.invitation.email,
    password: '',
    password_confirmation: '',
    token: props.invitation.token,
});

const acceptInvitation = () => {
    useForm({}).post(`/team-invitations/${props.invitation.token}`);
};

const registerAndAccept = () => {
    form.post(`/team-invitations/${props.invitation.token}`);
};
</script>
