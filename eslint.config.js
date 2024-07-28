import pluginVue from 'eslint-plugin-vue'
export default [
    // add more generic rulesets here, such as:
    // js.configs.recommended,
    ...pluginVue.configs['flat/recommended'],
    // ...pluginVue.configs['flat/vue2-recommended'], // Use this if you are using Vue.js 2.x.
    {
        rules: {
            // override/add rules settings here, such as:
            'prettier/prettier': ['error'],
            'vue/require-default-prop': 'off',
            'vue/html-indent': ['error', 4],
            'vue/singleline-html-element-content-newline': 0,
            'vue/component-name-in-template-casing': ['error', 'PascalCase'],
            'vue/no-unused-vars': 'error',
            'semi': ["error", "never"]
        }
    }
]