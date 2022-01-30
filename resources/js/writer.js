import Alpine from 'alpinejs'
import BubbleMenu from '@tiptap/extension-bubble-menu'
import Highlight from '@tiptap/extension-highlight'
import Link from '@tiptap/extension-link'
import Placeholder from '@tiptap/extension-placeholder'
import StarterKit from '@tiptap/starter-kit'
import TextAlign from '@tiptap/extension-text-align'
import Typography from '@tiptap/extension-typography'
import Underline from '@tiptap/extension-underline'
import {Editor} from '@tiptap/core'

Alpine.data('writer', (content, id) => ({
    editor: null,
    linkEditor: false,
    content: content,
    touched: null,
    linkHref: null,
    linkTarget: '_self',

    init() {
        const data = this;
        this.editor = new Editor({
            element: this.$refs.tiptap,
            content: this.content,
            extensions: [
                StarterKit,
                Placeholder.configure({
                    placeholder: 'Write something remarkable …'
                }),
                BubbleMenu.configure({
                    element: this.$refs.bubbleMenu,
                    tippyOptions: {
                        zIndex: 40
                    }
                }),
                TextAlign.configure({
                    types: ['heading', 'paragraph'],
                }),
                Underline,
                Highlight,
                Typography,
                Link.configure({
                    openOnClick: false
                }),
            ],
            editorProps: {
                attributes: {
                    class: 'w-full mx-auto prose prose-blue outline-none dark:text-gray-100'
                }
            },

            onCreate: () => {
                data.touched = Date.now()
            },

            onUpdate: ({editor}) => {
                data.touched = Date.now()
                this.content = editor.getHTML()
            },

            onSelectionUpdate: ({editor}) => {
                data.touched = Date.now()
            },

            onBlur: () => {
                data.touched = Date.now()
            },

            onFocus: () => {
                data.touched = Date.now()
            }
        })
    },

    theEditor() {
        return Alpine.raw(this.editor);
    },

    /*
        Passing touched here to make Alpine
        make the editor buttons reactive.

        The value of touched is updated
        on every Tiptap transaction.
    */
    isActive(type, opts = {}, touched) {
        return this.editor.isFocused && this.editor.isActive(type, opts);
    },

    openLinkEditor() {
        this.$store.modals['linkEditor-' + id] = true

        this.linkHref = this.editor.getAttributes('link').href ?? null
        this.linkTarget = this.editor.getAttributes('link').target ?? '_self'
    },

    setLink() {
        this.theEditor().chain().focus().setLink({
            href: this.linkHref,
            target: this.linkTarget
        }).run();
        this.$store.modals['linkEditor-' + id] = false;
    },

    removeLink() {
        this.theEditor().chain().focus().unsetLink().run();
        this.$store.modals['linkEditor-' + id] = false;
    }
}))
