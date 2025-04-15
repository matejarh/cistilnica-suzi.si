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
        props.isSmall ? 'text-xs md:text-sm p-1' : 'p-1 text-xs md:text-base'
    ]
})
const iconClasses = computed(() => {
    return [
        props.isSmall ? 'h-3 w-3 md:w-4 md:h-4' : 'h-3 w-3 md:w-4 md:h-4'
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
        action: () => editor.value.chain().focus().undo().run(),
        icon: icons.UndoIcon,
        label: '',
        active: editor.value?.isActive('undo')
    },
    {
        condition: true,
        action: () => editor.value.chain().focus().redo().run(),
        icon: icons.RedoIcon,
        label: '',
        active: editor.value?.isActive('redo')
    },
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
    },
    {
        condition: !props.isSmall && props.hasHeadings,
        action: () => editor.value.chain().focus().unsetAllMarks().run(),
        icon: icons.ClearFormattingIcon,
        label: '',
        active: editor.value?.isActive( 'unsetAllMarks' )
    },
    {
        condition: !props.isSmall && props.hasHeadings,
        action: () => editor.value.chain().focus().toggleBulletList().run(),
        icon: icons.BulletListIcon,
        label: '',
        active: editor.value?.isActive('bulletList')
    },
    {
        condition: !props.isSmall && props.hasHeadings,
        action: () => editor.value.chain().focus().toggleOrderedList().run(),
        icon: icons.NumberedListIcon,
        label: '',
        active: editor.value?.isActive('orderedList')
    },

])

onBeforeUnmount(() => {
  editor.value.destroy()
})
</script>


<style>

.prose {
    color: var(--tw-prose-body);
    --tw-prose-body: oklch(37.3% .034 259.733);
    --tw-prose-headings: oklch(21% .034 264.665);
    --tw-prose-lead: oklch(44.6% .03 256.802);
    --tw-prose-links: oklch(21% .034 264.665);
    --tw-prose-bold: oklch(21% .034 264.665);
    --tw-prose-counters: oklch(55.1% .027 264.364);
    --tw-prose-bullets: oklch(87.2% .01 258.338);
    --tw-prose-hr: oklch(92.8% .006 264.531);
    --tw-prose-quotes: oklch(21% .034 264.665);
    --tw-prose-quote-borders: oklch(92.8% .006 264.531);
    --tw-prose-captions: oklch(55.1% .027 264.364);
    --tw-prose-kbd: oklch(21% .034 264.665);
    --tw-prose-kbd-shadows: NaN NaN NaN;
    --tw-prose-code: oklch(21% .034 264.665);
    --tw-prose-pre-code: oklch(92.8% .006 264.531);
    --tw-prose-pre-bg: oklch(27.8% .033 256.848);
    --tw-prose-th-borders: oklch(87.2% .01 258.338);
    --tw-prose-td-borders: oklch(92.8% .006 264.531);
    --tw-prose-invert-body: oklch(87.2% .01 258.338);
    --tw-prose-invert-headings: #fff;
    --tw-prose-invert-lead: oklch(70.7% .022 261.325);
    --tw-prose-invert-links: #fff;
    --tw-prose-invert-bold: #fff;
    --tw-prose-invert-counters: oklch(70.7% .022 261.325);
    --tw-prose-invert-bullets: oklch(44.6% .03 256.802);
    --tw-prose-invert-hr: oklch(37.3% .034 259.733);
    --tw-prose-invert-quotes: oklch(96.7% .003 264.542);
    --tw-prose-invert-quote-borders: oklch(37.3% .034 259.733);
    --tw-prose-invert-captions: oklch(70.7% .022 261.325);
    --tw-prose-invert-kbd: #fff;
    --tw-prose-invert-kbd-shadows: 255 255 255;
    --tw-prose-invert-code: #fff;
    --tw-prose-invert-pre-code: oklch(87.2% .01 258.338);
    --tw-prose-invert-pre-bg: #00000080;
    --tw-prose-invert-th-borders: oklch(44.6% .03 256.802);
    --tw-prose-invert-td-borders: oklch(37.3% .034 259.733);
    max-width: 100% !important;
    font-size: 1rem;
    line-height: 1.25rem;
    margin-top: 0;
    margin-bottom: 0;
    padding: 0;
    font-family: inherit;

}
</style>
