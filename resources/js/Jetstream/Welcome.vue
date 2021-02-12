<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div>
                <jet-application-logo class="block h-12 w-auto" />
            </div>

            <div class="mt-8 text-2xl">
                Bienvenue sur Miaulitter !
            </div>

            <div class="mt-6 text-gray-500">
                Miaulitter permet à votre chat de communiquer ses besoins les plus élémentaires à ses serviteurs. Miaulitter a déjà sauvé 17 343 ficus. Vous aussi, faites un geste pour la planète : sauvez un ficus.
            </div>
        </div>
    </div>
</template>

<script>
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo'

    export default {
        components: {
            JetApplicationLogo,
        },
    }
</script>
