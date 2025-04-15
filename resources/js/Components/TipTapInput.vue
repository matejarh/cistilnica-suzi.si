<template>
    <div id="wrapper" class="rounded-lg w-full border" :class="errorClasses">
        <div v-if="editor" :class="isSmall ? 'py-0' : 'py-2'" class="flex items-center justify-between px-3 border-b dark:border-gray-600">
            <div class="w-full flex justify-between flex-wrap items-center divide-gray-200 sm:divide-x sm:rtl:divide-x-reverse dark:divide-gray-600">
                <div class="left justify-self-stretch flex flex-wrap items-center space-x-1 rtl:space-x-reverse sm:pe-4">
                    <template v-for="(button, index) in toolbarButtons" :key="index">
                        <button v-if="button.condition" @click.prevent="button.action" :class="[buttonClasses, button.active ? activeButtonClasses : '']">
                            <div class="flex">
                                <component :is="button.icon" :class="iconClasses" />
                                <span v-if="button.label">{{ button.label }}</span>
                            </div>
                        </button>
                    </template>
                </div>
                <button class="justify-self-end" @click.prevent="toggleFullScreen" :class="[buttonClasses]">
                    <icons.FullScreenIcon :class="iconClasses" />
                </button>
            </div>
        </div>
        <div class="px-4 py-2 rounded-b-lg bg-neutral-light" :class="hasError ? 'bg-red-100' : ' bg-neutral-light'">
            <editor-content :editor="editor" />
        </div>
    </div>
</template>

<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Highlight from '@tiptap/extension-highlight'
import TextAlign from '@tiptap/extension-text-align'
import { computed, onBeforeUnmount, ref, watch, watchEffect } from 'vue';
import { icons } from '@/icons'

const props = defineProps({
    modelValue: {
      type: String,
      default: '',
    },
    hasError: {
        default: false,
        type: Boolean,
    },
    isSmall: {
        default: false,
        type: Boolean,
    },
    hasHeadings: {
        default: true,
        type: Boolean,
    },
})
const emitUpdate = defineEmits(['update:modelValue'])

const shake = ref(false)

const editor = useEditor({
    content: props.modelValue,
    extensions: [
        StarterKit,
        TextAlign.configure({
            types: ['heading', 'paragraph'],
        }),
        Highlight,
    ],
    editorProps: {
        attributes: {
            class: 'prose prose-sm sm:prose-base lg:prose-base xl:prose-base m-2 focus:outline-none  ',
        },
    },

    onUpdate({ editor }) {
        emitUpdate('update:modelValue', editor.getHTML())
    },
})

const initiateShake = () => {
    shake.value = true
    setTimeout(() => {
        shake.value = false
    }, 1500);
}

watchEffect(() => {
    if (props.hasError === true) {
        initiateShake()
    }
})

watch(props, (value) => {
  const isSame = editor.value.getHTML() === props.modelValue

  if (!isSame) {
    editor.value.commands.setContent(props.modelValue, false)
  }
})

const errorClasses = computed(() => {
    return [
        props.hasError ? 'border-red-600 bg-red-50 dark:bg-gray-700 dark:border-red-600' : 'border-primary bg-white',
        shake.value ? 'animate-shake' : ''
    ]
})

const buttonClasses = computed(() => {
    return [
        ' font-bold text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600',
        props.isSmall ? 'text-xs md:text-sm p-1' : 'p-2 text-xs md:text-base'
    ]
})
const iconClasses = computed(() => {
    return [
        props.isSmall ? 'h-3 w-3 md:w-4 md:h-4' : 'h-3 w-3 md:w-6 md:h-6'
    ]
})

const activeButtonClasses = computed(() => {
    return 'text-gray-900 bg-gray-100 dark:text-white dark:bg-gray-600'
})

const toggleFullScreen = () => {
    const container = document.querySelector('#wrapper');
    if (container) {
        if (!document.fullscreenElement) {
            container.requestFullscreen().catch(err => {
                console.error(`Error attempting to enable fullscreen mode: ${err.message}`);
            });
        } else {
            document.exitFullscreen().catch(err => {
                console.error(`Error attempting to exit fullscreen mode: ${err.message}`);
            });
        }
    }
}

const toolbarButtons = computed(() => [
    {
        condition: !props.isSmall && props.hasHeadings,
        action: () => editor.value.chain().focus().toggleHeading({ level: 1 }).run(),
        icon: icons.HeadingIcon,
        label: '1',
        active: editor.value?.isActive('heading', { level: 1 })
    },
    {
        condition: !props.isSmall && props.hasHeadings,
        action: () => editor.value.chain().focus().toggleHeading({ level: 2 }).run(),
        icon: icons.HeadingIcon,
        label: '2',
        active: editor.value?.isActive('heading', { level: 2 })
    },
    {
        condition: !props.isSmall && props.hasHeadings,
        action: () => editor.value.chain().focus().toggleHeading({ level: 3 }).run(),
        icon: icons.HeadingIcon,
        label: '3',
        active: editor.value?.isActive('heading', { level: 3 })
    },
    {
        condition: !props.isSmall && props.hasHeadings,
        action: () => editor.value.chain().focus().toggleHeading({ level: 4 }).run(),
        icon: icons.HeadingIcon,
        label: '4',
        active: editor.value?.isActive('heading', { level: 4 })
    },
    {
        condition: !props.isSmall && props.hasHeadings,
        action: () => editor.value.chain().focus().toggleHeading({ level: 5 }).run(),
        icon: icons.HeadingIcon,
        label: '5',
        active: editor.value?.isActive('heading', { level: 5 })
    },
/*     {
        condition: !props.isSmall && props.hasHeadings,
        action: () => editor.value.chain().focus().setParagraph().run(),
        icon: icons.ParagraphIcon,
        label: '',
        active: editor.value?.isActive('paragraph')
    }, */
    {
        condition: true,
        action: () => editor.value.chain().focus().toggleBold().run(),
        icon: icons.BoldIcon,
        label: '',
        active: editor.value?.isActive('bold')
    },
    {
        condition: true,
        action: () => editor.value.chain().focus().toggleItalic().run(),
        icon: icons.ItalicIcon,
        label: '',
        active: editor.value?.isActive('italic')
    },
    {
        condition: true,
        action: () => editor.value.chain().focus().toggleStrike().run(),
        icon: icons.TextSlashIcon,
        label: '',
        active: editor.value?.isActive('strike')
    },
    {
        condition: true,
        action: () => editor.value.chain().focus().toggleHighlight().run(),
        icon: icons.HighlightIcon,
        label: '',
        active: editor.value?.isActive('highlight')
    },
    {
        condition: !props.isSmall && props.hasHeadings,
        action: () => editor.value.chain().focus().setTextAlign('left').run(),
        icon: icons.AlignLeftIcon,
        label: '',
        active: editor.value?.isActive({ textAlign: 'left' })
    },
    {
        condition: !props.isSmall && props.hasHeadings,
        action: () => editor.value.chain().focus().setTextAlign('center').run(),
        icon: icons.AlignCenterIcon,
        label: '',
        active: editor.value?.isActive({ textAlign: 'center' })
    },
    {
        condition: !props.isSmall && props.hasHeadings,
        action: () => editor.value.chain().focus().setTextAlign('right').run(),
        icon: icons.AlignRightIcon,
        label: '',
        active: editor.value?.isActive({ textAlign: 'right' })
    },
    {
        condition: !props.isSmall && props.hasHeadings,
        action: () => editor.value.chain().focus().setTextAlign('justify').run(),
        icon: icons.AlignJustifyIcon,
        label: '',
        active: editor.value?.isActive({ textAlign: 'justify' })
    }
])

onBeforeUnmount(() => {
  editor.value.destroy()
})
</script>
