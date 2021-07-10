module.exports = {
  parser: 'vue-eslint-parser',
  parserOptions: {
    parser: '@babel/eslint-parser'
  },
  extends: [
    'eslint-config-standard',
    'plugin:eslint-plugin-compat/recommended',
    'plugin:eslint-plugin-vue/vue3-essential',
    'plugin:@intlify/eslint-plugin-vue-i18n/recommended'
  ],
  settings: {
    'import/resolver': 'webpack',
    'vue-i18n': {
      localeDir: {
        pattern: './assets/scripts/i18n/translations/*.json',
        localeKey: 'file'
      },
      messageSyntaxVersion: '^9.0.0'
    }
  },
  rules: {
    '@intlify/vue-i18n/no-raw-text': 'off',
    'arrow-parens': ['error', 'as-needed']
  }
}
