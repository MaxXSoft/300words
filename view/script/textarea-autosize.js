Vue.component('textarea-autosize', {
  template: '<textarea @focus="resize" v-model="val" :style="computedStyles"></textarea>',
  created: function () {
    this.updateVal() // fill val with initial value passed via the same name prop
  },
  mounted: function () {
    this.resize() // perform initial height adjustment
  },
  props: {
    /*
     * Property to accept value from parent
     */
    value: {
      type: [String, Number],
      default: ''
    },
    /*
     * Allow to enable/disable auto resizing dynamically
     */
    autosize: {
      type: Boolean,
      default: true
    },
    /*
     * Min textarea height
     */
    minHeight: {
      type: [Number],
      default: null
    },
    /*
     * Max textarea height
     */
    maxHeight: {
      type: [Number],
      default: null
    },
    /*
     * Force !important for style properties
     */
    important: {
      type: [Boolean, Array],
      default: false
    }
  },
  data: function () {
    return {
      // data property for v-model binding with real textarea tag
      val: null,
      // works when content height becomes more then value of the maxHeight property
      maxHeightScroll: false
    }
  },
  computed: {
    /*
     */
    computedStyles: function () {
      let objStyles = {}
      if (this.autosize) {
        objStyles.resize = !this.isResizeImportant ? 'none' : 'none !important'
        if (!this.maxHeightScroll) {
          objStyles.overflow = !this.isOverflowImportant ? 'hidden' : 'hidden !important'
        }
      }
      return objStyles
    },
    isResizeImportant: function () {
      const imp = this.important
      return imp === true || (Array.isArray(imp) && imp.includes('resize'))
    },
    isOverflowImportant: function () {
      const imp = this.important
      return imp === true || (Array.isArray(imp) && imp.includes('overflow'))
    },
    isHeightImportant: function () {
      const imp = this.important
      return imp === true || (Array.isArray(imp) && imp.includes('height'))
    }
  },
  methods: {
    /*
     * Update local val with prop value
     */
    updateVal: function () {
      this.val = this.value
    },
    /*
     * Auto resize textarea by height
     */
    resize: function () {
      const important = this.isHeightImportant ? 'important' : ''
      this.$el.style.setProperty('height', 'auto', important)
      let contentHeight = this.$el.scrollHeight + 1
      if (this.minHeight) {
        contentHeight = contentHeight < this.minHeight ? this.minHeight : contentHeight
      }
      if (this.maxHeight) {
        if (contentHeight > this.maxHeight) {
          contentHeight = this.maxHeight
          this.maxHeightScroll = true
        } else {
          this.maxHeightScroll = false
        }
      }
      const heightVal = contentHeight + 'px'
      this.$el.style.setProperty('height', heightVal, important)
      return this
    }
  },
  watch: {
    /*
     * Update val from prop when changed in parent
     */
    value: function () {
      this.updateVal()
    },
    /*
     * Emit input event as in https://vuejs.org/v2/guide/components.html#Form-Input-Components-using-Custom-Events
     */
    val: function (val) {
      this.$nextTick(this.resize)
      this.$emit('input', val)
    }
  }
})
