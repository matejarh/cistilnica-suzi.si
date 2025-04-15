<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Editor, EditorContent, BubbleMenu, FloatingMenu } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';

const editor = ref(null);

const emit = defineEmits(['update:modelValue']);
const props = defineProps({
    modelValue: {
        type: String,
        default: '<p>Sem vnesi opis akcije ali promocije...</p>',
    },
});

onMounted(() => {
    editor.value = new Editor({
        extensions: [
            StarterKit,
        ],
        content: props.modelValue,
        onUpdate: ({ editor }) => {
            // console.log('Editor content updated:', editor.getHTML());
            emit('update:modelValue', editor.getHTML());
        },
    });
});

onBeforeUnmount(() => {
    if (editor.value) {
        editor.value.destroy();
    }
});
</script>

<template>
    <div>
        <!-- Bubble Menu -->
        <bubble-menu
            class="bubble-menu"
            :editor="editor"
            :tippy-options="{ appendTo: 'parent', duration: 100 }"
        >
            <button @click="editor.chain().focus().toggleBold().run()" :class="{ 'is-active': editor.isActive('bold') }">
                Krepko
            </button>
            <button @click="editor.chain().focus().toggleItalic().run()" :class="{ 'is-active': editor.isActive('italic') }">
                Nagnjeno
            </button>
            <button @click="editor.chain().focus().toggleStrike().run()" :class="{ 'is-active': editor.isActive('strike') }">
                Prečrtano
            </button>
        </bubble-menu>

        <!-- Floating Menu -->
        <floating-menu
            class="floating-menu"
            :editor="editor"
            :tippy-options="{ appendTo: 'parent', duration: 100 }"
        >
            <button @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
                :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }">
                H1
            </button>
            <button @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
                :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }">
                H2
            </button>
            <button @click="editor.chain().focus().toggleBulletList().run()"
                :class="{ 'is-active': editor.isActive('bulletList') }">
                Bullet list
            </button>
        </floating-menu>

        <!-- Editor Content -->
        <EditorContent :editor="editor" class="block p-3 w-full text-sm text-neutral-dark bg-neutral-light hover:bg-white focus:bg-white rounded-lg border border-neutral-light focus:ring-primary-light focus:border-primary-light" />
    </div>
</template>

<style scoped>
.bubble-menu {
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    gap: 8px;
    padding: 8px;
}

.floating-menu {
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    gap: 8px;
    padding: 8px;
}

button {
    background: none;
    border: none;
    padding: 4px 8px;
    cursor: pointer;
    border-radius: 4px;
    transition: background 0.2s;
    color: #333;
}

button:hover {
    background: #f0f0f0;
}

button.is-active {
    background: #007bff;
    color: white;
}
</style>
