<template>
    <div>
        <label class="sr-only">{{ label }}</label>
        <div class="flex mt-1 rounded-md shadow-sm">
             <span v-if="prepend"
                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm"
             >
                {{ prepend }}
             </span>
             <template v-if="type === 'select'">
                <select :name="name"
                        :required="required"
                        :value="props.modelValue"
                        :class="inputClasses"
                        :selectOptions="selectOptions"
                        @change="onChange($event.target.value)">
                    <option v-for="option of selectOptions" :value="option.key" :key="option.key">{{option.text}}</option>
                </select>
            </template>
             <template v-if="type === 'textarea'">
                <textarea :name="name"
                        :value="props.modelValue"
                        :required="required"
                        @input="emit('update:modelValue', $event.target.value)"
                        :class="inputClasses"
                        :placeholder="label"
                        :maxSize = "maxSize"
                >
                </textarea>
             </template>
             <template v-else-if=" type === 'file'">
                <input :type="type"
                    :name="name"
                    :required="required"
                    :value="props.modelValue"
                    @input="inputFileChange($event)"
                    :class="inputClasses"
                    :placeholder="label"
                />
             </template>
             <template v-else>
                <input :type="type"
                    :name="name"
                    :required="required"
                    :value="props.modelValue"
                    @input="emit('update:modelValue', $event.target.value)"
                    :class="inputClasses"
                    :placeholder="label"
                    step="0.01"
                />
             </template>
             <span v-if="append"
                    class="inline-flex items-center px-3 rounded-r-md border-l-0 border-gray-300
                    bg-gray-50 text-gray-500 text-sm"
             >
                {{ append }}
             </span>
        </div>
    </div>
</template>
<script setup>
import { computed } from "vue";
import { useToast } from "primevue/usetoast";
const toast = useToast();
const props = defineProps({
    modelValue: [ String, Number, File],
    label: String,
    type: {
        type: String,
        default: 'text'
    },
    name: String,
    required: Boolean,
    multiple: Boolean,
    prepend: {
        type: String,
        default: ''
    },
    append: {
        type: String,
        default: ''
    },
    maxSize: {
        type: Number,
        default: 2097152
    },
    selectOptions: Array
});

const inputClasses = computed(() => {
    const cls = [
        `block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900
        focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm`
    ];
    if (props.append && !props.prepend) {
    cls.push(`rounded-l-md`);
  } else if (props.prepend && !props.append) {
    cls.push(`rounded-r-md`);
  } else if (!props.prepend && !props.append) {
    cls.push('rounded-md');
  }
    return cls.join(' ');
});
const emit = defineEmits(['update:modelValue', 'change']);

function inputFileChange(event) {
    if(event.target.files[0].size > props.maxSize) {
        toast.add({
            severity: "error",
            summary: "Error",
            detail: `Image Size must be equal or less than ${formatSize(props.maxSize)}`,
            life: 3000,
        });
        event.target.value = null;
        emit('change', event.target.files[0]);
    } else {
        emit('change', event.target.files[0]);
    }
}

function onChange(value) {
  emit('update:modelValue', value)
  emit('change', value)
}

function formatSize(bytes){
    if (bytes === 0) return "0 B";
    const k = 1024;
    const sizes = ["B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
};
</script>
