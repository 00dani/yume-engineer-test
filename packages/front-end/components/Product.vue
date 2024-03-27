<script setup lang="ts">
    import type { Product } from '~/models'
    const props = defineProps({
        product: {
            type: Object as PropType<Product>,
            required: true
        }
    })
</script>
<template>
    <div class="mb-4 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
        <div class="border border-grey cursor-pointer rounded-lg hover:shadow w-full">
            <div class="px-4 pt-6">
                <div class="inline-block grid justify-end">
                    <div class="text-red-600">⏱ 10 hrs</div>
                </div>

                <div class="h-58 flex items-center">
                    <img class="w-1/2 mr-2" :src="`https://cataas.com/cat?c=${product.id}`" />
                    <div class="font-bold text-lg text-center line-clamp-2">
                        {{ product.name }}
                    </div>
                </div>

                <div class="text-sm my-4">
                    from
                    <span class="text-red-600">
                        <span class="text-3xl font-bold">${{ product.price }}</span> 
                        / carton
                    </span>
                </div>

                <div class="text-sm mb-2 flex justify-between">
                    <div>BBD</div>
                    <div class="font-bold">[DD/MM/YYYY]</div>
                </div>

                <div class="text-sm mb-2 flex justify-between">
                    <div>Qty Available</div>
                    <div>[xx] cartons</div>
                </div>

                <div class="text-sm mb-2 flex justify-between">
                    <div>Min Order</div>
                    <div>[xx] cartons</div>
                </div>

                <div class="text-sm mb-2 flex justify-between">
                    <div>State</div>
                    <div>[State]</div>
                </div>
            </div>
        </div>
    </div>
</template>
