Nova.booting((Vue, router, store) => {
  Nova.inertia('SettingsTool', require('./views/Settings').default);
  Vue.component('SettingsLoadingButton', require('./components/SettingsLoadingButton').default);
});
