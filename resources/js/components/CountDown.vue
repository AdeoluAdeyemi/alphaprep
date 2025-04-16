<!-- script -->
<script lang="ts" setup>
import { ref, onMounted } from 'vue';
const timer1: any = ref(null);
const demo1: any = ref({
    days: null,
    hours: null,
    minutes: null,
    seconds: null,
});

onMounted(() => {
    setTimerDemo1();
});

const setTimerDemo1 = () => {
    let date = new Date();
    date.setDate(date.getDate() + 3);
    let countDownDate = date.getTime();

    timer1.value = setInterval(() => {
        let now = new Date().getTime();

        let distance = countDownDate - now;

        demo1.value.days = Math.floor(distance / (1000 * 60 * 60 * 24));
        demo1.value.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        demo1.value.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        demo1.value.seconds = Math.floor((distance % (1000 * 60)) / 1000);

        if (distance < 0) {
        clearInterval(timer1.value);
        }
    }, 500);
};
</script>

<template>
    <!-- simple countdown -->
    <div class="mb-5 grid grid-cols-4 justify-items-center gap-3">
    <div>
        <div class="w-16 h-16 sm:w-[100px] sm:h-[100px] shadow-[1px_2px_12px_0_rgba(31,45,61,0.10)] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] flex justify-center flex-col">
        <h1 class="text-primary sm:text-3xl text-xl text-center">{{ demo1.days }}</h1>
        </div>
        <h4 class="text-[#3b3f5c] text-[15px] mt-4 text-center dark:text-white-dark font-semibold">Days</h4>
    </div>
    <div>
        <div class="w-16 h-16 sm:w-[100px] sm:h-[100px] shadow-[1px_2px_12px_0_rgba(31,45,61,0.10)] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] flex justify-center flex-col">
        <h1 class="text-primary sm:text-3xl text-xl text-center">{{ demo1.hours }}</h1>
        </div>
        <h4 class="text-[#3b3f5c] text-[15px] mt-4 text-center dark:text-white-dark font-semibold">Hours</h4>
    </div>
    <div>
        <div class="w-16 h-16 sm:w-[100px] sm:h-[100px] shadow-[1px_2px_12px_0_rgba(31,45,61,0.10)] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] flex justify-center flex-col">
        <h1 class="text-primary sm:text-3xl text-xl text-center">{{ demo1.minutes }}</h1>
        </div>
        <h4 class="text-[#3b3f5c] text-[15px] mt-4 text-center dark:text-white-dark font-semibold">Mins</h4>
    </div>
    <div>
        <div class="w-16 h-16 sm:w-[100px] sm:h-[100px] shadow-[1px_2px_12px_0_rgba(31,45,61,0.10)] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] flex justify-center flex-col">
        <h1 class="text-primary sm:text-3xl text-xl text-center">{{ demo1.seconds }}</h1>
        </div>
        <h4 class="text-[#3b3f5c] text-[15px] mt-4 text-center dark:text-white-dark font-semibold">Sec</h4>
    </div>
    </div>
</template>
