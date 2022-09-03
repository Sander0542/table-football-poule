<template>

    <div class="-ml-4 -mt-4 flex justify-between items-center flex-wrap sm:flex-nowrap">
        <div class="ml-4 mt-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <slot></slot>
            </h2>
        </div>
        <div class="ml-4 mt-4 flex-shrink-0 flex">
            <slot name="actions"></slot>
        </div>
    </div>
</template>
