<div x-data="{
    showPreloader:false
}"
     x-on:show-preloader.window="showPreloader=true"
     x-on:hide-preloader.window="showPreloader=false"
>
    <template x-if="showPreloader">
        <div class="absolute min-h-screen bg-gray-800 opacity-50 w-full z-50"></div>
    </template>
</div>
