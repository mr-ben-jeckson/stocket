<template>
    <div class="container my-5 py-5 px-3 bg-white rounded-md shadow-md">
        <form @submit.prevent="onSubmit">
            <div class="grid grid-cols-4 max-sm:grid-cols-none max-md:grid-cols-2">
                <div class="w-full col-span-4 max-md:col-span-2 max-sm:col-auto px-2 py-4">
                    <h3 class="text-2xl font-semibold">{{ props.stock.id ? 'Edit Stock' : 'Add New Stock' }}</h3>
                </div>
                <div class="w-full px-2 py-4">
                    <div class="flex my-auto">
                        <Checkbox v-model="productHasSize" :binary="true" />
                        <label class="ml-3 text-sm text-gray-500">Product Stock Has Size or Weight</label>
                    </div>
                </div>
                <div class="w-full px-2 py-4">
                    <div class="flex my-auto">
                        <Checkbox v-model="productHasColor" @change="setPhoto(productHasColor)" :binary="true" />
                        <label class="ml-3 text-sm text-gray-500">Product Stock Has Color</label>
                    </div>
                </div>
                <div class="w-full px-2 py-4">
                    <div class="flex my-auto">
                        <Checkbox v-model="colorHasImage" @change="setColor(colorHasImage)" :binary="true" />
                        <label class="ml-3 text-sm text-gray-500">Stock Color Has A Photo</label>
                    </div>
                </div>
                <div class="w-full px-2 py-4">
                    <div class="flex my-auto">
                        <Checkbox v-model="productHasExtraPlus" :binary="true" />
                        <label class="ml-3 text-sm text-gray-500">Different Unit Price</label>
                    </div>
                </div>
                <div v-if="productHasSize" class="w-full px-2 py-4">
                    <label id="size" class="text-sm text-gray-500">Size or Weight</label>
                    <InputText id="size" placeholder="Eg. XL or 10g" v-model="stock.size" class="w-full" />
                </div>
                <div v-if="productHasColor" class="w-full px-2 py-4">
                    <label id="color" class="text-sm text-gray-500">Fill color name</label>
                    <Dropdown id="color" v-model="stock.color" :options="colors" filter showClear optionLabel="name"
                        placeholder="Select a Color" panelClass="max-sm:w-full" class="w-full">
                        <template #value="slotProps">
                            <div v-if="slotProps.value" class="flex align-items-center">
                                <span class="mr-2 py-[7px] px-[7px] w-[18px] h-[18px] my-auto border border-gray-200"
                                    :style="`background: ${slotProps.value.hex}`"></span>
                                <div>{{ slotProps.value.name }}</div>
                            </div>
                            <span v-else>
                                {{ slotProps.placeholder }}
                            </span>
                        </template>
                        <template #option="slotProps">
                            <div class="flex align-items-center">
                                <span class="mr-2 py-[7px] px-[7px] w-[18px] h-[18px] my-auto border border-gray-200"
                                    :style="`background: ${slotProps.option.hex}`"></span>
                                <div>{{ slotProps.option.name }}</div>
                            </div>
                        </template>
                    </Dropdown>
                </div>
                <div v-if="colorHasImage" class="w-full px-2 py-3">
                    <label id="colorImage" class="text-sm text-gray-500">Product Image with that color</label>
                    <CustomInput id="colorImage" type="file" @change="file => stock.image = file" />
                </div>
                <div v-if="productHasExtraPlus" class="w-full px-2 py-4">
                    <label id="stock" class="text-sm text-gray-500">Plus Increment Price</label>
                    <InputNumber id="stock" v-model="stock.extraPlus" mode="currency" currency="USD" showButtons :min="1"
                        class="w-full" />
                </div>
                <div class="w-full px-2 py-4">
                    <label id="stock" class="text-sm text-gray-500">Stock on Inventroy</label>
                    <InputNumber id="stock" v-model="stock.stock" inputId="minmax-buttons" mode="decimal" showButtons
                        :min="1" :max="5000" class="w-full" />
                </div>
            </div>
            <div class="flex justify-between items-center mt-3">
                <button @click.prevent="closeForm()"
                    class="my-auto border-gray-200 shadow-sm py-2 px-8 border border-transparent text-sm font-medium rounded-md text-black bg-gray-200 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Close Form
                </button>
                <button type="submit"
                    class="my-auto border-gray-300 shadow-sm py-2 px-8 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-700 disabled:cursor-not-allowed disabled:bg-emerald-400"
                    :disabled="isLoading">
                    Save Stock
                </button>
            </div>
        </form>
    </div>
</template>
<script setup>
import InputText from "primevue/inputtext";
import Dropdown from 'primevue/dropdown';
import Button from "primevue/button";
import InputNumber from 'primevue/inputnumber';
import CustomInput from "../../components/core/CustomInput.vue";
import Checkbox from 'primevue/checkbox';
import color from '../../assets/color';
import { computed, ref, watchEffect } from "vue";
import { useToast } from "primevue/usetoast";
const isLoading = ref(false);
const colors = ref(
    color
);
const toast = useToast();
const productHasSize = ref(props.stock.size ? true : false);
const productHasColor = ref(props.stock.color ? true : false);
const colorHasImage = ref(props.stock.image ? true : false);
const productHasExtraPlus = ref(props.stock.plus ? true : false);
const stock = ref({
    id: props.stock.id,
    productId: props.stock.productId,
    size: props.stock.size,
    color: props.stock.color,
    type: props.stock.type,
    image: props.stock.image,
    plus: props.stock.plus,
    stock: props.stock.stock,
    extraPlus: Number(props.stock.extraPlus),
});

watchEffect(() => {
    stock.value = {
        id: props.stock.id,
        productId: props.stock.productId,
        size: props.stock.size,
        color: props.stock.color,
        type: props.stock.type,
        image: props.stock.image,
        plus: props.stock.plus,
        stock: props.stock.stock,
        extraPlus: Number(props.stock.extraPlus)
    },
        productHasSize.value = props.stock.size ? true : false,
        productHasColor.value = props.stock.color ? true : false,
        colorHasImage.value = props.stock.image ? true : false,
        productHasExtraPlus.value = props.stock.plus ? true : false
});

const props = defineProps({
    modelValue: Boolean,
    stock: {
        required: true,
        type: Object,
    },
    price: {
        required: true,
        type: Number
    }
});
const emit = defineEmits(["update:modelValue"]);
const closeForm = () => {
    emit('update:modelValue');
}
const setPhoto = (value) => {
    if(value === false) {
        colorHasImage.value = value;
    }
}
const setColor = (value) => {
    if(value === true) {
        productHasColor.value = true;
    }
}
const result = computed(() => props.price + stock.value.extraPlus);
const onSubmit = () => {
    const stockObj = {
        size: stock.value.size,
        color: stock.value.color,
        image: stock.value.image,
        plus: stock.value.plus,
        extraPlus: stock.value.extraPlus,
        stock: stock.value.stock
    }
    console.log(stockObj);
}
</script>
