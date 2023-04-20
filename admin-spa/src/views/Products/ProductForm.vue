<template>
    <div class="bg-white p-4 rounded-lg shadow mb-3">
        <div class="row-auto justify-between pb-3 mb-3">
            <form @submit.prevent="onSubmit()">
                <Toast />
                <div class="bg-white px-4 pt-5 pb-4">
                    <h2 class="text-2xl font-semibold">{{ product.id ? `Update Product: "${props.product.title}"` : 'Create new Product' }}</h2>
                </div>
                <div class="w-full px-3 py-5">
                    <div class="grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-none">
                        <div class="w-auto px-2 mb-5">
                            <span class="p-float-label">
                                <InputText id="productTitle" v-model="product.title" class="w-full" />
                                <label for="productTitle">Product Title</label>
                            </span>
                        </div>
                        <div class="w-auto lg:col-span-3 md:col-span-2 px-2 mb-5">
                            <div class="p-inputgroup flex-1">
                                <MultiSelect id="ms-category" v-model="product.category" display="chip" filter
                                    :options="category" optionLabel="name" :maxSelectedLabels="category.length" :selectionLimit="5" placeholder="Select Categories" class="w-full" />
                                <Button icon="pi pi-plus-circle" />
                            </div>
                        </div>
                        <div class="w-auto lg:col-span-4 md:col-span-2 px-2 mb-5 mt-5">
                            <span class="p-float-label">
                                <Textarea v-model="product.description" rows="5" class="w-full" />
                                <label>Description</label>
                            </span>
                        </div>
                        <div class="w-auto lg:col-span-4 md:col-span-2 px-2 mb-5 mt-5">
                            <!-- File Upload -->
                            <div class="card">
                                    <FileUpload @select="onAdvancedUpload($event)" @clear="selectFileClear()" :showUploadButton="false" @remove="onAdvancedUpload($event)" :multiple="true" accept="image/*" :fileLimit="10" :maxFileSize="2000000" ref="filesSelector">
                                        <template #empty>
                                            <p>Drag and drop image files to here to attach.</p>
                                        </template>
                                        <template #content="{ files, messages, removeFileCallback }">
                                            <div v-if="files.length > 0">
                                                <div v-if="messages.length > 0 && files.length > 0">
                                                    <div v-for="(message, index) of messages" :key="index">
                                                        <Message severity="error" :life="3000" :sticky="false">{{message}}</Message>
                                                    </div>
                                                </div>
                                                <div class="container">
                                                    <div class="grid 2xl:grid-cols-6 lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-none max-sm:grid-cols-none">
                                                            <div v-for="(file, index) of files" :key="file.name + file.type + file.size" class="flex flex-col justify-items-center border-2 rounded border-gray-200 px-2 py-5 m-1">
                                                            <div class="px-2 justify-center items-center">
                                                                <img role="presentation" :alt="file.name" :src="file.objectURL" class="shadow-2 w-[125px] h-[80px] object-cover mx-auto" />
                                                            </div>
                                                            <div class="w-full text-center py-3">
                                                                <span class="text-sm break-words">{{ file.name }}</span>
                                                            </div>
                                                            <div class="px-2 font-semibold text-center">{{ formatSize(file.size) }}</div>
                                                            <div class="px-2 py-5 text-center">
                                                                <Button icon="pi pi-times" @click="onRemoveTemplatingFile(file, removeFileCallback, index)" outlined rounded  severity="danger" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </FileUpload>
                            </div>
                        </div>
                        <div class="w-auto px-2 mb-5 mt-5">
                            <InputNumber v-model="product.price" inputId="stacked-buttons" showButtons mode="currency" currency="USD" class="w-full" />
                        </div>
                        <div class="w-auto lg:col-span-3 md:col-span-2 px-2 mb-5 mt-5">
                            <div class="p-inputgroup flex-1">
                                <MultiSelect id="ms-category" v-model="product.tag" display="chip" filter
                                    :options="tag" optionLabel="name" :maxSelectedLabels="tag.length" :selectionLimit="5" placeholder="Select Tags" class="w-full" />
                                <Button icon="pi pi-plus-circle" />
                            </div>
                        </div>
                        <div class="w-atuo lg:col-span-4 md:col-span-2 px-2 mb-5 mt-5">
                            <button type="submit" class="mt-3 w-full inline-flex justify-center border-gray-300 shadow-sm
                          py-2 px-4 border border-transparent text-sm font-medium rounded-md
                           text-white bg-blue-600 hover:bg-blue-700 focus:outline-none
                           focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:cursor-none disabled:bg-blue-400" v-bind:disabled="isLoading">
                                        Submit
                                    </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script setup>
import { computed, onMounted, ref } from 'vue';
//theme
import "../../assets/theme.css";
//core
import "primevue/resources/primevue.min.css";
//icons
import "primeicons/primeicons.css";
//components
import InputText from 'primevue/inputtext';
import MultiSelect from 'primevue/multiselect';
import Textarea from 'primevue/textarea';
import FileUpload from 'primevue/fileupload';
import InputNumber from 'primevue/inputnumber';
import Toast from 'primevue/toast';
import Message from 'primevue/message';
import Badge from 'primevue/badge';
import Button from 'primevue/button';
import { useToast } from "primevue/usetoast";
import store from '../../store';

const isLoading = ref(false);
const filesSelector = ref(null);
const product = ref({
    id: props.product.id,
    title: props.product.title,
    image: props.product.image,
    description: props.product.description,
    price: props.product.price,
});

const category = computed(() => store.state.category.data);
const tag = computed(() => store.state.tag.data);
console.log(tag);
const props = defineProps({
    product: {
        required: true,
        type: Object
    },
})

onMounted(() => {
    getCategory();
    getTag();
})

function getCategory() {
    store.dispatch('getCategory');
}

function getTag() {
    store.dispatch('getTag');
}

const formatSize = (bytes) => {
    if (bytes === 0) return "0 B";
    const k = 1024;
    const sizes = ["B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
};

const totalSize = ref(0);
const files = ref([]);

const onAdvancedUpload = (e) => {
    product.value.image = Array.from(e.files);
    files.value = e.files;
    files.value.forEach((file) => {
        totalSize.value += parseInt(formatSize(file.size));
    });
};

const onRemoveTemplatingFile = (file, removeFileCallback, index) => {
    removeFileCallback(index);
    totalSize.value -= parseInt(formatSize(file.size));
};

const selectFileClear = () => {
    product.value.image = [];
}

const toast = useToast();

const onSubmit = () => {
    //custom validation with primevue toast
    if(!product.value.title) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Title is required', life: 3000 });
        return;
    } else if(!product.value.description) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Description is required', life: 3000 });
        return;
    } else if(!product.value.price || product.value.price < 0.00) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Price must be greater than 0.0', life: 3000 });
        return;
    } else if(!product.value.image || product.value.image.length == 0) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Product must has an image atleast', life: 3000 });
        return;
    }
    isLoading.value = true;
    toast.add({ severity: 'info', summary: 'Info', detail: 'Product is being saved'});
    store.dispatch('createProduct', product.value)
            .then(response => {
                isLoading.value = false;
                toast.removeAllGroups();
                if (response.status === 201) {
                    toast.add({ severity: 'success', summary: 'Success', detail: 'Product was added', life: 3000 })
                    filesSelector.value.clear();
                    product.value = {};
                    product.value.price = 0.00;
                    //show notification
                    store.dispatch('getProducts');
                }
            })
}

</script>
