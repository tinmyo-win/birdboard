<template>
    <div class="dropdown">
        <div 
            class="dropdown-toggle relative" 
            @click.prevent="isOpen = !isOpen"
            aria-haspopup="true"
            :aria-expanded="isOpen"
        >
            <!-- trigger -->
            <slot name="trigger">

            </slot>
            </div>

        <div 
            class="dropdown-menu absolute bg-card py-2 rounded shadow mt-2" 
            :class="align === 'left' ? 'pin-l' : 'pin-r'"
            :style="{width}"
            v-show="isOpen">
            <!-- menu links-->
            <slot>

            </slot>
        </div>

    </div>
</template>

<script>
export default {
    props: {
        width: { default: 'auto' },
        align: { default: 'left' }
    },
  data() {
    return { isOpen: false };
  },

  watch: {
    isOpen(isOpen) {
        if(isOpen) {
            document.addEventListener('click', this.closeIfClickedOutside)
        }
    }
  },

  methods: {
    closeIfClickedOutside(event) {
        if(! event.target.closest('.dropdown')) {
            this.isOpen = false;
            document.removeEventListener('click', this.closeIfClickedOutside)
        }
    }
  }
};
</script>
