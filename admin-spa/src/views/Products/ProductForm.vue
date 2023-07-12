<template>
    <div class="bg-white p-4 rounded-lg shadow mb-3">
        <div class="row-auto justify-between pb-3 mb-3">
            <form @submit.prevent="onSubmit()">
                <div class="bg-white px-4 pt-5 pb-4">
                    <h2 class="text-2xl font-semibold">
                        {{
                            product.id
                                ? `Update Product: "${props.product.title}"`
                                : 'Create new Product'
                        }}
                    </h2>
                </div>
                <div class="w-full px-3 py-5">
                    <div
                        class="grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-none"
                    >
                        <div class="w-auto px-2 mb-5">
                            <span class="p-float-label">
                                <InputText
                                    id="productTitle"
                                    v-model="product.title"
                                    class="w-full"
                                />
                                <label for="productTitle">Product Title</label>
                            </span>
                        </div>
                        <div class="w-auto lg:col-span-3 px-2 mb-5">
                            <div class="p-inputgroup flex-1">
                                <MultiSelect
                                    id="ms-category"
                                    v-model="product.category"
                                    display="comma"
                                    filter
                                    :options="category"
                                    optionLabel="name"
                                    :maxSelectedLabels="0"
                                    :selectionLimit="5"
                                    placeholder="Select Categories"
                                    class="w-full"
                                />
                                <Button
                                    icon="pi pi-plus-circle"
                                    @click="showCategoryForm()"
                                />
                            </div>
                            <CategoryModal v-model="isShowCategoryForm" @update:visible="closeCategoryForm()" />
                        </div>
                        <div
                            v-if="
                                product.category && product.category.length > 0
                            "
                            class="w-auto lg:col-span-4 md:col-span-2 px-2 mb-5 mt-5"
                        >
                            <Tag
                                icon="pi pi-bars"
                                value="Primary"
                                v-for="(category, index) of product.category"
                                :key="index"
                                class="m-2"
                                >{{ category.name }}
                                <span
                                    class="pi pi-times text-sm"
                                    @click="removeCategory(category.id)"
                                ></span>
                            </Tag>
                        </div>
                        <div
                            class="w-auto lg:col-span-4 md:col-span-2 px-2 mb-5 mt-5"
                        >
                            <span class="p-float-label">
                                <Textarea
                                    v-model="product.description"
                                    rows="5"
                                    class="w-full"
                                />
                                <label>Description</label>
                            </span>
                        </div>
                        <div
                            class="w-auto lg:col-span-4 md:col-span-2 px-2 mb-5 mt-5"
                        >
                            <!-- Edit Form Exist Images -->
                            <div
                                v-if="
                                    props.product.image &&
                                    props.product.image.length > 0
                                "
                                class="card mb-5 border-2 rounded border-gray-200 px-2 py-5"
                            >
                                <p class="px-2 text-gray-500 py-2">
                                    The following images are a gallery of the
                                    product. You can remove each till an image.
                                    Please click choose button to add more
                                    image.
                                </p>
                                <div class="container">
                                    <Loader v-if="isLoading" class="my-8" />
                                    <div
                                        v-else
                                        class="grid 2xl:grid-cols-6 lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-none max-sm:grid-cols-none"
                                    >
                                        <div
                                            v-for="(file, index) of props
                                                .product.image"
                                            :key="index"
                                            class="flex flex-col justify-items-center border-2 rounded shadow border-gray-200 px-2 py-5 m-1"
                                        >
                                            <div
                                                class="px-2 py-3 justify-center items-center"
                                            >
                                                <img
                                                    role="presentation"
                                                    :alt="file.url"
                                                    :src="file.url"
                                                    class="shadow-2 w-[125px] h-[80px] object-cover mx-auto"
                                                />
                                            </div>
                                            <div
                                                class="px-2 font-semibold text-center"
                                            >
                                                {{ formatSize(file.size) }}
                                            </div>
                                            <div class="px-2 py-3 text-center">
                                                <!-- Just only show more than an image -->
                                                <Button
                                                    v-if="
                                                        props.product.image
                                                            .length > 1
                                                    "
                                                    icon="pi pi-times"
                                                    @click="
                                                        singleImageRemove(
                                                            props.product.id,
                                                            file.id,
                                                            file.url
                                                        )
                                                    "
                                                    outlined
                                                    rounded
                                                    severity="danger"
                                                    size="small"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- File Upload -->
                            <div class="card">
                                <FileUpload
                                    @select="onAdvancedUpload($event)"
                                    @clear="selectFileClear()"
                                    :showUploadButton="false"
                                    @remove="onAdvancedUpload($event)"
                                    :multiple="true"
                                    accept="image/*"
                                    :fileLimit="10"
                                    :maxFileSize="2000000"
                                    ref="filesSelector"
                                >
                                    <template #empty>
                                        <p class="text-gray-500">
                                            Drag and drop image files to here to
                                            attach.
                                        </p>
                                    </template>
                                    <template
                                        #content="{
                                            files,
                                            messages,
                                            removeFileCallback
                                        }"
                                    >
                                        <div v-if="files.length > 0">
                                            <div
                                                v-if="
                                                    messages.length > 0 &&
                                                    files.length > 0
                                                "
                                            >
                                                <div
                                                    v-for="(
                                                        message, index
                                                    ) of messages"
                                                    :key="index + message"
                                                >
                                                    <Message
                                                        severity="error"
                                                        life="3000"
                                                        sticky="false"
                                                        >{{ message }}</Message
                                                    >
                                                </div>
                                            </div>
                                            <div class="container">
                                                <div
                                                    class="grid 2xl:grid-cols-6 lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-none max-sm:grid-cols-none"
                                                >
                                                    <div
                                                        v-for="(
                                                            file, index
                                                        ) of files"
                                                        :key="
                                                            file.name +
                                                            file.type +
                                                            file.size
                                                        "
                                                        class="flex flex-col justify-items-center border-2 rounded shadow border-gray-200 px-2 py-5 m-1"
                                                    >
                                                        <div
                                                            class="px-2 justify-center items-center"
                                                        >
                                                            <img
                                                                role="presentation"
                                                                :alt="file.name"
                                                                :src="
                                                                    file.objectURL
                                                                "
                                                                class="shadow-2 w-[125px] h-[80px] object-cover mx-auto"
                                                            />
                                                        </div>
                                                        <div
                                                            class="w-full text-center py-3"
                                                        >
                                                            <span
                                                                class="text-sm break-words"
                                                                >{{
                                                                    file.name
                                                                }}</span
                                                            >
                                                        </div>
                                                        <div
                                                            class="px-2 font-semibold text-center"
                                                        >
                                                            {{
                                                                formatSize(
                                                                    file.size
                                                                )
                                                            }}
                                                        </div>
                                                        <div
                                                            class="px-2 py-5 text-center"
                                                        >
                                                            <Button
                                                                icon="pi pi-times"
                                                                @click="
                                                                    onRemoveTemplatingFile(
                                                                        file,
                                                                        removeFileCallback,
                                                                        index
                                                                    )
                                                                "
                                                                outlined
                                                                rounded
                                                                severity="danger"
                                                                size="small"
                                                            />
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
                            <span class="p-float-label">
                                <InputNumber
                                    id="price"
                                    v-model="product.price"
                                    inputId="stacked-buttons"
                                    :min="0.0"
                                    showButtons
                                    mode="currency"
                                    currency="USD"
                                    class="w-full"
                                />
                                <label for="price">Product Price</label>
                            </span>
                        </div>
                        <div class="w-auto lg:col-span-3 px-2 mb-5 mt-5">
                            <div class="p-inputgroup flex-1 w-full">
                                <MultiSelect
                                    v-model="product.tag"
                                    display="comma"
                                    filter
                                    :options="tag"
                                    optionLabel="name"
                                    :maxSelectedLabels="0"
                                    placeholder="Select Tags"
                                    class="w-full"
                                />
                                <Button icon="pi pi-plus-circle" />
                            </div>
                        </div>
                        <div
                            v-if="product.tag && product.tag.length > 0"
                            class="w-auto lg:col-span-4 md:col-span-2 px-2 mb-5 mt-5"
                        >
                            <Tag
                                icon="pi pi-tag"
                                value="Primary"
                                v-for="(tag, index) of product.tag"
                                :key="index"
                                class="m-2"
                                >{{ tag.name }}
                                <span
                                    class="pi pi-times text-sm"
                                    @click="removeTag(tag.id)"
                                ></span>
                            </Tag>
                        </div>
                        <div
                            class="w-auto lg:col-span-4 md:col-span-2 px-2 mb-5 mt-5"
                        >
                            <div class="card flex justify-content-center">
                                <InputSwitch
                                    id="published"
                                    v-model="product.published"
                                />
                                <label
                                    for="published"
                                    class="ml-2 text-gray-500"
                                >
                                    Published the product for customers
                                </label>
                            </div>
                        </div>

                        <!-- Feature Form-->
                        <div
                            class="w-auto lg:col-span-4 md:col-span-2 px-2 my-5"
                        >
                            <draggable
                                v-model="product.features"
                                item-key="index"
                                @start="drag = true"
                                @end="drag = false"
                            >
                                <template #item="{ element, index }">
                                    <div class="cursor-move">
                                        <div
                                            class="grid grid-cols-12 gap-2 w-full my-3"
                                        >
                                            <div
                                                class="col-span-11 max-sm:col-span-10 my-3 w-full"
                                            >
                                                <div
                                                    class="flex justify-between items-center"
                                                >
                                                    <div class="w-full pr-2">
                                                        <span
                                                            class="p-float-label"
                                                        >
                                                            <InputText
                                                                id="productFeatureHead"
                                                                v-model="
                                                                    element.head
                                                                "
                                                                class="w-full"
                                                            />
                                                            <label
                                                                for="productFeatureHead"
                                                                >Feature Name
                                                                {{
                                                                    index + 1
                                                                }}</label
                                                            >
                                                        </span>
                                                    </div>
                                                    <div class="w-full pl-2">
                                                        <span
                                                            class="p-float-label"
                                                        >
                                                            <InputText
                                                                id="productFeatureText"
                                                                v-model="
                                                                    element.text
                                                                "
                                                                class="w-full"
                                                            />
                                                            <label
                                                                for="productFeatureText"
                                                                >Feature Text
                                                                {{
                                                                    index + 1
                                                                }}</label
                                                            >
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="max-sm:col-span-2 my-auto flex justify-end"
                                            >
                                                <button
                                                    :disabled="index === 0"
                                                    @click.prevent="
                                                        removeFeature(index)
                                                    "
                                                    class="my-auto text-sm text-red-600"
                                                >
                                                    <i
                                                        :class="
                                                            index === 0
                                                                ? 'pi pi-lock'
                                                                : 'pi pi-trash'
                                                        "
                                                    ></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <template #footer>
                                    <div
                                        class="w-auto lg:col-span-4 md:col-span-2 mb-5 mt-5"
                                    >
                                        <div
                                            class="card flex justify-start justify-items-center"
                                        >
                                            <button
                                                @click.prevent="addFeature()"
                                            >
                                                <i
                                                    class="pi pi-plus-circle text-blue-600 my-auto"
                                                ></i>
                                            </button>
                                            <label
                                                for="addFeature"
                                                class="ml-2 my-auto text-gray-500"
                                            >
                                                Add more feature. You can drag
                                                to sort the above features
                                            </label>
                                        </div>
                                    </div>
                                </template>
                            </draggable>
                        </div>

                        <div
                            class="w-auto lg:col-span-4 md:col-span-2 px-2 mb-5 mt-5"
                        >
                            <div class="flex justify-between">
                                <button
                                    @click.prevent="closeForm()"
                                    class="my-auto border-gray-200 shadow-sm py-2 px-8 border border-transparent text-sm font-medium rounded-md text-black bg-gray-200 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                                >
                                    Close Form
                                </button>
                                <button
                                    type="submit"
                                    class="my-auto border-gray-300 shadow-sm py-2 px-8 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:cursor-not-allowed disabled:bg-blue-400"
                                    :disabled="isLoading"
                                >
                                    Save Product
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script setup>
import { computed, onMounted, watchEffect, ref } from 'vue'
import Loader from '../../components/core/Loader.vue'
import InputText from 'primevue/inputtext'
import MultiSelect from 'primevue/multiselect'
import Textarea from 'primevue/textarea'
import FileUpload from 'primevue/fileupload'
import InputNumber from 'primevue/inputnumber'
import Message from 'primevue/message'
import Tag from 'primevue/tag'
import Button from 'primevue/button'
import InputSwitch from 'primevue/inputswitch'
import { useToast } from 'primevue/usetoast'
import draggable from 'vuedraggable'
import CategoryModal from '../Categories/CategoryModal.vue'
import store from '../../store'

const isLoading = ref(false)
const filesSelector = ref(null)
const updateImages = ref([])
const product = ref({
    id: props.product.id,
    title: props.product.title,
    image: props.product.image,
    description: props.product.description,
    price: Number(props.product.price),
    category: props.product.category,
    tag: props.product.tag,
    published: props.product.published,
    features: props.product.features
})
const isShowCategoryForm = ref(false)

const category = computed(() => store.state.category.data)
const tag = computed(() => store.state.tag.data)

const show = computed({
    get: () => props.modelValue,
    set: value => emit('update:modelValue', value)
})

const props = defineProps({
    modelValue: Boolean,
    product: {
        required: true,
        type: Object
    }
})

const emit = defineEmits(['update:modelValue'])

watchEffect(() => {
    product.value = {
        id: props.product.id,
        title: props.product.title,
        image: props.product.images,
        description: props.product.description,
        price: Number(props.product.price),
        category: props.product.category,
        tag: props.product.tag,
        published: props.product.published,
        features: props.product.features
    }
})

onMounted(() => {
    getCategory()
    getTag()
})

function getCategory () {
    store.dispatch('getCategory');
}

function getTag () {
    store.dispatch('getTag')
}

function addFeature () {
    product.value.features.push({
        head: '',
        text: ''
    })
}

function showCategoryForm () {
    isShowCategoryForm.value = true
}

function closeCategoryForm() {
    getCategory();
    isShowCategoryForm.value = false;
}

function removeFeature (index) {
    product.value.features.splice(index, 1)
}

function removeCategory (id) {
    product.value.category = product.value.category.filter(cat => cat.id !== id)
}

const formatSize = bytes => {
    if (bytes === 0) return '0 B'
    const k = 1024
    const sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
    const i = Math.floor(Math.log(bytes) / Math.log(k))
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

const totalSize = ref(0)
const files = ref([])

const onAdvancedUpload = e => {
    //update
    if (props.product.id) {
        updateImages.value = Array.from(e.files)
    } else {
        product.value.image = Array.from(e.files)
    }
    files.value = e.files
    files.value.forEach(file => {
        totalSize.value += parseInt(formatSize(file.size))
    })
}

const onRemoveTemplatingFile = (file, removeFileCallback, index) => {
    removeFileCallback(index)
    totalSize.value -= parseInt(formatSize(file.size))
}

function selectFileClear () {
    if (props.product.id) {
        updateImages.value = []
    } else {
        product.value.image = []
    }
}

function closeForm () {
    show.value = false
    filesSelector.value.clear()
    product.value.features.length = 0
    product.value.features.push({
        head: '',
        text: ''
    })
    emit('update:modelValue')
}

const toast = useToast()

function singleImageRemove (id, index, url) {
    isLoading.value = true
    store
        .dispatch('deleteSingleImageProduct', {
            id,
            index,
            url
        })
        .then(response => {
            isLoading.value = false
            if (response.status === 422) {
                console.log(response.message)
            }
            if (response.status === 201) {
                toast.add({
                    severity: 'success',
                    summary: 'Success',
                    detail: "The image was removed from product's gallery",
                    life: 3000
                })
                props.product.image = response.data
            }
            store.dispatch('getProducts')
        })
}

function removeTag (id) {
    product.value.tag = product.value.tag.filter(tag => tag.id !== id)
}

function onSubmit () {
    //custom validation with primevue toast // to insall some validation library
    if (!product.value.title) {
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Title is required',
            life: 3000
        })
        return
    } else if (!product.value.description) {
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Description is required',
            life: 3000
        })
        return
    } else if (!product.value.price || product.value.price < 0.0) {
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Price must be greater than 0.0',
            life: 3000
        })
        return
    } else if (
        product.value.features.length === 0 ||
        product.value.features[0].head === '' ||
        product.value.features[0].text === ''
    ) {
        toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Product must has one feature atleast',
            life: 3000
        })
        return
    }

    const productObj = {
        title: product.value.title,
        description: product.value.description,
        category: product.value.category
            ? product.value.category.map(item => item.id)
            : undefined,
        tag: product.value.tag
            ? product.value.tag.map(item => item.id)
            : undefined,
        price: product.value.price,
        published: product.value.published === true ? 1 : 0,
        features: product.value.features
    }

    const createProductObj = {
        ...productObj,
        image: product.value.image
    }

    const updateProductObj = {
        ...productObj,
        id: product.value.id,
        image: updateImages.value
    }

    isLoading.value = true
    if (props.product.id) {
        toast.add({
            severity: 'info',
            summary: 'Info',
            detail: 'Product is being updated'
        })
        store.dispatch('updateProduct', updateProductObj).then(response => {
            isLoading.value = false
            toast.removeAllGroups()
            if (response.status === 200) {
                toast.add({
                    severity: 'success',
                    summary: 'Success',
                    detail: 'Product was updated',
                    life: 3000
                })
                filesSelector.value.clear()
                closeForm()
                store.dispatch('getProducts')
            }
        })
    } else {
        toast.add({
            severity: 'info',
            summary: 'Info',
            detail: 'Product is being saved'
        })
        store.dispatch('createProduct', createProductObj).then(response => {
            isLoading.value = false
            toast.removeAllGroups()
            if (response.status === 201) {
                toast.add({
                    severity: 'success',
                    summary: 'Success',
                    detail: 'Product was added',
                    life: 3000
                })
                filesSelector.value.clear()
                closeForm()
                store.dispatch('getProducts')
            }
        })
    }
}
</script>
