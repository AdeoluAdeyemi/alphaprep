<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { useCurrency } from '@/composables/useCurrency'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    currency: '',
    locale: '',
    timezone: '',
    address: '',
//    address2: '',
    city: '',
    state: '',
    country: '',
    zip_code: '',
});

// Combine address 1 and address 2
//form.address = `${form.address} ${form.address2}`

const {timezone, locale, currency } = useCurrency()

// Set currency, timezone and locale
form.currency= currency
form.locale = locale
form.timezone = timezone

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AuthBase title="Create an account" description="Enter your details below to create your account">
        <Head title="Register" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input id="name" type="text" required autofocus :tabindex="1" autocomplete="name" v-model="form.name" placeholder="Full name" />
                        <InputError :message="form.errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="email">Email address</Label>
                        <Input id="email" type="email" required :tabindex="2" autocomplete="email" v-model="form.email" placeholder="email@example.com" />
                        <InputError :message="form.errors.email" />
                    </div>
                </div>

                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="3"
                        autocomplete="new-password"
                        v-model="form.password"
                        placeholder="Password"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirm password</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        :tabindex="4"
                        autocomplete="new-password"
                        v-model="form.password_confirmation"
                        placeholder="Confirm password"
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <div class="grid gap-2">
                    <Label for="address">Email address</Label>
                    <Input
                        id="address"
                        type="text"
                        v-model="form.address"
                        required
                        autofocus
                        autocomplete="address"
                    />

                    <InputError :message="form.errors.address" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="grid gap-2">
                        <Label for="city">City</Label>
                        <Input
                            id="city"
                            type="text"
                            v-model="form.city"
                            required
                            autofocus
                            autocomplete="city"
                        />

                        <InputError :message="form.errors.city" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="state">State</Label>
                        <Input
                            id="state"
                            type="text"
                            v-model="form.state"
                            required
                            autofocus
                            autocomplete="state"
                        />

                        <InputError :message="form.errors.state" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="grid gap-2">
                        <Label for="city">Postcode/Zip</Label>
                        <Input
                            id="zip_code"
                            type="text"
                            v-model="form.zip_code"
                            required
                            autofocus
                            autocomplete="zip_code"
                        />

                        <InputError :message="form.errors.zip_code" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="country">Country</Label>
                        <Input
                            id="country"
                            type="text"
                            v-model="form.country"
                            required
                            autofocus
                            autocomplete="country"
                        />

                        <InputError :message="form.errors.country" />
                    </div>
                </div>

                <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Create account
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Already have an account?
                <TextLink :href="route('login')" class="underline underline-offset-4" :tabindex="6">Log in</TextLink>
            </div>
        </form>
    </AuthBase>
</template>
