<template>
    <jet-action-section>
        <template #title>
            Quitter le paradis des chats
        </template>

        <template #description>
            Supprimer définitivement mon compte.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Une fois votre compte supprimé, vous ne pourrez plus accéder aux orgies félines que vous appréciez tant en ces lieux saints.
            </div>

            <div class="mt-5">
                <jet-danger-button @click.native="confirmUserDeletion">
                    Supprimer mon compte
                </jet-danger-button>
            </div>

            <!-- Delete Account Confirmation Modal -->
            <jet-dialog-modal :show="confirmingUserDeletion" @close="closeModal">
                <template #title>
                    Supprimer compte
                </template>

                <template #content>
                    Êtes-vous sûr que vous ne serez pas en manque de cul ? Si oui, tapez votre mot de passe

                    <div class="mt-4">
                        <jet-input type="password" class="mt-1 block w-3/4" placeholder="Comment vivre sans stupre ni stupeur ?"
                                    ref="password"
                                    v-model="form.password"
                                    @keyup.enter.native="deleteUser" />

                        <jet-input-error :message="form.errors.password" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <jet-secondary-button @click.native="closeModal">
                        Si en fait le cul c'est cardianal
                    </jet-secondary-button>

                    <jet-danger-button class="ml-2 mt-3" @click.native="deleteUser" :class="{ 'opacity-25': form.processingn }" :disabled="form.processing">
                        J'opte pour 4 000 ans d'ascèse tantrique sur le modèle de mon maître Shiva Chat
                    </jet-danger-button>
                </template>
            </jet-dialog-modal>
        </template>
    </jet-action-section>
</template>

<script>
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            JetActionSection,
            JetDangerButton,
            JetDialogModal,
            JetInput,
            JetInputError,
            JetSecondaryButton,
        },

        data() {
            return {
                confirmingUserDeletion: false,

                form: this.$inertia.form({
                    password: '',
                })
            }
        },

        methods: {
            confirmUserDeletion() {
                this.confirmingUserDeletion = true;

                setTimeout(() => this.$refs.password.focus(), 250)
            },

            deleteUser() {
                this.form.delete(route('current-user.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => this.closeModal(),
                    onError: () => this.$refs.password.focus(),
                    onFinish: () => this.form.reset(),
                })
            },

            closeModal() {
                this.confirmingUserDeletion = false

                this.form.reset()
            },
        },
    }
</script>
