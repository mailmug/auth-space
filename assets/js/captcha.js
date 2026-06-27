export default () => ({
    captchaProvider: null,

    async runCaptcha(action = 'register') {
        if (typeof this.captchaProvider === 'function') {
            return await this.captchaProvider(action);
        }

        return null;
    }
});