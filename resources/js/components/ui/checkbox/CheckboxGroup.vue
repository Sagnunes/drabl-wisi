<script setup lang="ts">
import type { CheckboxGroupRootEmits, CheckboxGroupRootProps } from 'reka-ui'
import { cn } from '@/lib/utils'
import { CheckboxGroupRoot, useForwardPropsEmits } from 'reka-ui'
import { computed, type HTMLAttributes } from 'vue'

const props = defineProps<CheckboxGroupRootProps & { class?: HTMLAttributes['class'] }>()
const emits = defineEmits<CheckboxGroupRootEmits>()

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props

  return delegated
})

const forwarded = useForwardPropsEmits(delegatedProps, emits)
</script>

<template >
  <CheckboxGroupRoot
    data-slot="checkbox-group"
    v-bind="forwarded"
    :class="cn(props.class)"
  >
    <slot></slot>
  </CheckboxGroupRoot>
</template>
